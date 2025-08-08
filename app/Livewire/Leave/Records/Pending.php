<?php

namespace App\Livewire\Leave\Records;

use Carbon\Carbon;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use App\Models\LeaveEmployeeRequest;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Pending extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public function convertDate($dates)
    {
        $i = 1;
        $formattedDates = [];
        $previousMonth = '';
        foreach ($dates as $date) {
            // $newDate = Carbon::parse( $date);
            // if (!!$previousMonth) {
            //     if($newDate->isSameMonth(Carbon::parse($previousMonth)))
            //     {
            //         $formattedDates[] =  Carbon::parse($date)->format('j Y');
            //     }else{
            //         $i = 1;
            //         $formattedDates[] = $i == 1 ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y');
            //     }
            // }else{
            $formattedDates[] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y'); // Format to "Nov 12"
            // }

            // $i++;
            // $previousMonth = $date;
        }
        $groupedByYear = [];

        // Iterate through each date in the array
        foreach ($formattedDates as $date) {
            // Extract the year from the date string
            $parts = explode(' ', $date);
            $year = end($parts); // Get the last element, which is the year

            // Remove the year from the date string for grouping
            $dateWithoutYear = trim(str_replace($year, '', $date));

            // Group by year
            if (!isset($groupedByYear[$year])) {
                $groupedByYear[$year] = []; // Initialize the array for this year if it doesn't exist
            }
            $groupedByYear[$year][] = trim($dateWithoutYear); // Add the date to the corresponding year
        }

        // Output the grouped array
        // Initialize an array to hold the formatted strings
        $formattedStrings = [];

        // Iterate over each year and its corresponding dates
        foreach ($groupedByYear as $year => $dates) {
            $formattedDates = [];
            $lastMonth = '';

            foreach ($dates as $date) {
                // Extract the month and day
                list($month, $day) = explode(' ', $date);

                // If the month is the same as the last one, only add the day
                if ($month === $lastMonth) {
                    $formattedDates[] = $day;
                } else {
                    $formattedDates[] = $date; // Keep the full date (month and day)
                    $lastMonth = $month; // Update the last month
                }
            }

            // Join the dates with a comma
            $datesString = implode(', ', $formattedDates);
            // Combine the dates with the year
            $formattedStrings[] = "$datesString $year";
        }

        // Join the formatted strings with " And "

        // Join the formatted strings with " And "
        $output = implode(' - ', $formattedStrings);
        return $output;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(LeaveEmployeeRequest::query()->with(['employeeInfo'])->where('location', 'Records',)->where('type_of_process', 'WET SIGNATURE')->where('archived',0))
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('employeeInfo.name')->label('Employee Name')->searchable(),
                TextColumn::make('subject_title')->searchable()->toggleable()->wrap()->extraAttributes(['style' => 'width: 20rem']),
                TextColumn::make('type_of_leave')->searchable()->toggleable(),
                TextColumn::make('date')
                    ->formatStateUsing(function ($state) {
                        $state = json_decode($state);
                        return $this->convertDate($state);
                    })->searchable()->toggleable(),

                TextColumn::make('type_of_process')->toggleable(),
                TextColumn::make('location')->toggleable(),
                IconColumn::make('head_status')->label('HEAD')->toggleable()->boolean(),
                IconColumn::make('chief_status')->label('CAO/SAO')->toggleable()->boolean(),
                IconColumn::make('rd_status')->label('RD/ARD')->toggleable()->boolean(),

                TextColumn::make('status')->color(fn($state) => \App\Enums\LeaveStatusEnum::tryFrom($state)?->getColor())
                    ->badge()->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('Request_information')
                    ->label('Request Information')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->color(Color::Gray)
                    ->url(function ($record) {
                        $slug = str_replace(' ', '-', $record->subject_title);
                        $slug = Str::upper($slug);
                        return route('leave.request.view', ['request_id' => $record?->code, 'title' => $slug]);
                    }),
                    EditAction::make('upload')
                    ->label('Upload')
                    ->icon('heroicon-o-arrow-up-on-square-stack')
                    ->color(Color::Blue)
                    ->mutateRecordDataUsing(function (array $data,$record): array {
                        $data['signed_file'] = $record?->signed_file;

                        return $data;
                    })
                    ->form([
                        FileUpload::make('signed_file')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf'])->directory(function($record){
                            $name = $record->employeeInfo?->name;
                            return "leave/$name/";
                        })->required()->rules('required')
                    ])
                    ->action(function ($data,$record) {
                        $record->update($data);
                        $name = Auth::user()->name;
                        \App\Models\LeaveRequestLogs::create([
                            'activity' => "$name Upload Document",
                            'remarks' => "",
                            'location' =>  Auth::user()?->user_fd_code?->division_name ,
                            'id_number' => Auth::user()->id_number,
                            'leave_request_id' => $record->code,
                        ]);
                        Notification::make()
                        ->title('Saved successfully')
                        ->success()
                        ->send();
                    }),
                    Action::make('archived')

                    ->icon('heroicon-o-archive-box-arrow-down')
                    ->color(Color::Red)
                    ->action(fn($record) => $record->update(['archived'=>1]))
                    ->hidden(fn($record)=>!!$record->signed_file ? false : true),
                ])->iconButton()

            ]);
    }

    public function render(): View
    {
        return view('livewire.leave.records.pending');
    }
}
