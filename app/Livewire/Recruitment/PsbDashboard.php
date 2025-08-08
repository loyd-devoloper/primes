<?php

namespace App\Livewire\Recruitment;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Builder;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class PsbDashboard extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {

        return $table
            ->query(\App\Models\RecruitmentJobPsb::query()->with(['otherInfo'=>function($q){
                $q->with('jobDetails','batchDetails');
            }])->whereHas('jobInfos',function($q){
                $q->where('status_of_hiring','1');
            })->where('id_number',Auth::user()->id_number))


            ->columns([
                    TextColumn::make('otherInfo.jobDetails.job_title')->label('Position')->searchable(['job_title']),

                    TextColumn::make('dsad')->label('Batch')->state(fn ($record) => $record->otherInfo?->batchDetails?->batch_name),

            ])
            ->actions([
                ViewAction::make()->label('View Applicant')->url(fn($record): String => route('recruitment.psb.applicant',['job_batch'=>$record->otherInfo?->batchDetails?->batch_name,'job_id'=>$record->otherInfo?->job_id,'job_title'=>$record->otherInfo?->jobDetails?->job_title]))
            ])
            ->paginationPageOptions(['1', '5', '10', '20', '30', 'all'])->striped()->defaultSort('created_at', 'desc');
    }
    #[Title('PSB Dashboard')]
    public function render()
    {
        return view('livewire.recruitment.psb-dashboard');
    }
}
