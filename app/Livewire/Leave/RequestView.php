<?php

namespace App\Livewire\Leave;

use Carbon\Carbon;
use Filament\Tables;
use Livewire\Component;
use Carbon\CarbonPeriod;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\StaticAction;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\View\View;
use App\Models\LeaveEmployeeRequest;

use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Livewire;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\ViewField;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class RequestView extends Component implements HasForms,HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public $title = '';
    public array | null | object $leave;
    public $leavelogs = [];
    public function mount($title, $request_id)
    {
        $this->title = $title;
        $this->leave = LeaveEmployeeRequest::with('employeeInfo')->where('code', $request_id)->first();

        $this->leavelogs = \App\Models\LeaveRequestLogs::where('leave_request_id', $request_id)->orderByDesc('id')->get();
    }
    public function iconButtonAction(): Action
    {
        return Action::make('iconButton')
            ->label('Original Document')
            ->icon('heroicon-o-document-arrow-down')
            ->size('sm')
            ->action(function(){
                $name = $this->leave?->employeeInfo?->name;
                return response()->download(storage_path("app/public/leave/$name/" . $this->leave->original_file));
            })
            ->button();

    }
    public function iconPreviewAction(): Action
    {
        return ViewAction::make('iconPreview')
        ->record($this->leave)
        ->size('sm')
        ->label('preview')
        ->icon('heroicon-o-eye')
        ->color(Color::Gray)
        ->form(function ($record) {

            $i = 1;
            $formattedDates = [];

            foreach (json_decode($record->date) as $date) {

                $formattedDates[] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y'); // Format to "Nov 12"

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


            $output = implode(' - ', $formattedStrings);

            // esign
            $my_esign = \App\Models\LeaveEmployee::select('id_number', 'e_sign')->where('id_number', $record->id_number)->first();
            return [
                ViewField::make('rating')
                    ->view(
                        'livewire.leave.asset.previewForm6',
                        [

                            'e_sign' => $my_esign?->e_sign,
                            'inclusive_date'=>$output
                        ]
                    )
            ];
        })
        ->modalWidth(MaxWidth::FitContent)
        ->button();

    }
    public function convertDate($dates)
    {

        $formattedDates = [];

        foreach ($dates as $date) {

            $formattedDates[] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y'); // Format to "Nov 12"

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
    public function iconButtonSignedAction(): Action
    {
        return Action::make('iconButtonSignedAction')
            ->label('Signed Document')
            ->icon('heroicon-o-document-arrow-down')
            ->color(Color::Green)
            ->size('sm')
            ->action(function(){
                if(!!$this->leave['signed_file'])
                {
                    $name = $this->leave?->employeeInfo?->name;
                    return response()->download(storage_path("app/public/leave/$name/" . $this->leave['signed_file']));
                }

            })
            ->hidden(!!$this->leave['signed_file'] ? false : true)
            ->button();

    }
    public function iconButtonSignedWetAction(): Action
    {
        return Action::make('iconButtonSignedWetAction')
            ->record($this->leave)
            ->label('Signed Document')
            ->icon('heroicon-o-document-arrow-down')
            ->color(Color::Green)
            ->size('sm')
            ->form([
                PdfViewerField::make('signed_file')
                ->label(false)
                ->fileUrl(Storage::url($this->leave['signed_file']))
                ->minHeight('80svh')
            ])

            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->modalWidth(MaxWidth::ScreenTwoExtraLarge)
            ->hidden(!!$this->leave['signed_file'] ? false : true)
            ->button();

    }
    public function numberOfWorkingDays($days)
    {


        return $days == 1 ? "$days DAY" : "$days DAYS";
    }


    public function render(): View
    {
        return view('livewire.leave.request-view')->title($this->title);
    }
}
