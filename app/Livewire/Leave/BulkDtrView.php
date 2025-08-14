<?php

namespace App\Livewire\Leave;

use App\Models\User;
use Livewire\Component;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use App\Models\Leave\LeaveBulkDtr;

use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;

use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;

use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use App\Models\Leave\LeaveBulkDtrGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;

use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\ViewField;

use Filament\Notifications\Notification;
use App\Traits\Leave\PersonnelLeaveTrait;
use Filament\Tables\Actions\DeleteAction;
use Filament\Actions\Contracts\HasActions;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Coolsam\FilamentFlatpickr\Enums\FlatpickrTheme;
use Filament\Actions\Concerns\InteractsWithActions;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;

class BulkDtrView extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    use PersonnelLeaveTrait;
    public $file, $selectupdateDtr, $dtrArrView;

    public array $dtrArr = [];
    public $employee = [];
    public string $month = '';
    public $globalMonth;
    public $id = '';
    public function mount($dtr_group)
    {
        $this->id = $dtr_group;
    }
    public function table(Table $table): Table
    {
        $query = LeaveBulkDtr::query()->where('group_id', $this->id)->orderBy('date', 'desc');
        return $table
            ->query($query)
            ->columns([

                TextColumn::make('batch'),
                TextColumn::make('user_name')->searchable(),
                TextColumn::make('employee.name')->searchable(),

            ])
            ->deferFilters()
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Flatpickr::make('date')
                            ->theme(FlatpickrTheme::DARK)
                            ->monthSelect()
                    ])
                    ->query(function ($query, array $data) {

                        return $query
                            ->when(
                                $data['date'],
                                fn($query, $date) => $query->whereDate('date', Carbon::parse($date)),
                            );
                    })
                    ->indicateUsing(function (array $data) {
                        if (!$data['date']) {
                            return null;
                        }

                        return 'Date:  ' . Carbon::parse($data['date'])->format('F Y');
                    })
            ])
            ->actions([
                DeleteAction::make('delete'),
                ViewAction::make('information')
                    ->icon('heroicon-o-eye')
                    ->mutateRecordDataUsing(function ($data) {
                        $this->employee = [
                            'author_id' => $data['id_number']
                        ];
                        $this->dtrArrView = $data;
                        return $data;
                    })
                    ->form([
                        ViewField::make('viewDtr')
                            ->view('livewire.leave.asset.dtr_view')
                            ->registerActions([
                                \Filament\Forms\Components\Actions\Action::make('dtr')
                                    ->label('DTR')
                                    ->iconButton()
                                    ->icon('heroicon-m-printer')
                                    ->form(function ($arguments) {

                                        $keys = array_keys($arguments);
                                        $route = route('dtr_qrcode', ['dtr_id' => $keys[0]]);

                                        $image = QrCode::generate($route);

                                        $base64Image = 'data:image/svg+xml;base64,' . base64_encode($image);

                                        return [
                                            ViewField::make('dtr_print')
                                                ->view('livewire.leave.asset.dtr_print')
                                                ->viewData([
                                                    'data' => $arguments,
                                                    'qrcode' => $base64Image
                                                ])
                                        ];
                                    })
                                    ->extraAttributes(['id' => 'dtr-id'])
                                    ->slideOver()
                                    ->modalSubmitAction(false),

                            ]),
                    ])
                    ->modalWidth(MaxWidth::FitContent)
                    ->slideOver()
            ])->deferFilters();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('author_id')
                    ->label('Author')
                    ->options(User::all()->pluck('name', 'id_number'))
                    ->searchable()
                    ->native(false)
                    ->extraAlpineAttributes(['x-on:change' => 'updateDtr($event.target.value,model)'])
            ])->statePath('employee');
    }
    public function updateDtr($data, $model)
    {

        $user = User::where('id_number', $data)->first();

        $dtr = LeaveBulkDtr::findOrFail($model['id']);
        if ($user) {
            $first = $dtr->first();
            if ($first) {
                $userold = User::where('id_number', $first->id_number)->first();
                if ($userold) {
                    $arrOld = json_decode($userold?->dtr_key, true) ?? [];

                    // Remove specific key (not array_pop!)
                    unset($arrOld[$model['user_name']]);

                    $userold->update([
                        'dtr_key' => json_encode($arrOld),
                    ]);

                    $arr = json_decode($user?->dtr_key, true) ?? [];

                    $arr[$model['user_name']] = $model['user_name'];
                    $user->update([
                        'dtr_key' => json_encode($arr),
                    ]);
                    $dtr->update(['id_number' => $data]);
                } else {
                    $arr = json_decode($user?->dtr_key, true) ?? [];

                    $arr[$model['user_name']] = $model['user_name'];
                    $user->update([
                        'dtr_key' => json_encode($arr),
                    ]);
                    $dtr->update(['id_number' => $data]);
                }
            }
        } else {
            $first = $dtr->first();
            if ($first) {
                $user = User::where('id_number', $first->id_number)->first();
                if ($user) {
                    $arr = json_decode($user->dtr_key, true) ?? [];

                    // Remove specific key (not array_pop!)
                    unset($arr[$model['user_name']]);

                    $user->update([
                        'dtr_key' => json_encode($arr),
                    ]);
                    $dtr->update(['id_number' => null]);
                }
            }
        }
    }
    public function render()
    {
        return view('livewire.leave.bulk-dtr-view');
    }
}
