<?php
namespace App\Traits;

use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Jenssegers\Agent\Facades\Agent;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

trait RecruitmentAttachmentFunctionTrait{

    public function perFile($file, $status,  $label,$action = false,$comment = false)
    {

        return Section::make($label)

            ->label(false)
            ->schema([
                Grid::make(5)->schema([
                    Placeholder::make('dsasdad')->columnSpan(5)->label($label),
                    \Filament\Forms\Components\Actions::make([

                        \Filament\Forms\Components\Actions\Action::make('onprogress')
                            ->badge()
                            ->label(function ($record) use ($status) {
                                if ($record->$status == 1) {
                                    return 'approved';
                                } else if ($record->$status == 2) {
                                    return 'reject';
                                }
                            })
                            ->color(function ($record) use ($status) {
                                if ($record->$status == 1) {
                                    return Color::Green;
                                } else if ($record->$status == 2) {
                                    return Color::Red;
                                } else if ($record->$status == 0) {
                                    return Color::Yellow;
                                }
                            })
                            ->icon('heroicon-o-arrow-path')
                            ->disabled()->hidden($action),

                    ])->columnSpan(4),
                    \Filament\Forms\Components\Actions::make([
                        \Filament\Forms\Components\Actions\Action::make($status . 'comment')
                            ->iconButton()
                            ->extraAttributes(['title' => 'Add Comment'])
                            ->icon('heroicon-o-chat-bubble-left-ellipsis')
                            ->label('add comment')
                            ->color(Color::Gray)
                            ->form([
                                \Filament\Forms\Components\Textarea::make('comment')->required()
                            ])
                            ->action(function ($data, $record) use ($label) {
                                \App\Models\RecruitmentApplicationFileComment::create([
                                    'application_id' => $record->id,
                                    'comment' => $data['comment'],
                                    'filename' => $label,
                                    'id_number' => Auth::user()->id_number
                                ]);
                                \App\Models\ApplicantLog::create([
                                    'activity' => 'Commented by '.Auth::user()->name,
                                    'message'=>$data['comment'] ,
                                    'id_number' => Auth::user()->id_number,
                                    'applicant_id' => $record->id,
                                    'type'=>'1'
                                ]);

                                Notification::make()
                                    ->title('Created successfully')
                                    ->success()
                                    ->send();
                            })->modalWidth(MaxWidth::ExtraSmall)
                            ->hidden(function() use($comment){
                                if(Auth::user()->can('RECRUITMENT')) return $comment;
                                if(Auth::user()->can('RECRUITMENT VIEW')) return true;

                            })
                           ,

                        \Filament\Forms\Components\Actions\Action::make($label)
                            ->label($label)
                            ->extraAttributes(['title' => 'View Attachment'])
                            ->icon('heroicon-o-eye')
                            ->iconButton()
                            ->form(function($record) use($file){

                              $link = '/recruitment/application/'.$record->jobInfo?->id.'/'.$record->batchInfo?->id.'/' . $record->email . '/' . $file;
                                return [
                                     Placeholder::make('no_attachment')->hidden(!!$file ? true : false),
                                     PdfViewerField::make('signed_file')
                                         ->hidden(!!$file ? false : true)
                                        ->label(false)
                                        ->fileUrl(function () use ($file,$link) {
                                            return !!$file ? Storage::url($link) : "";
                                        })
                                        ->minHeight('80svh')
                                        ];
                            })
                            ->slideOver()
                            // ->modalContent(function ($record) use ($file) {
                            //     $link = 'storage/recruitment/application/'.$record->jobInfo?->id.'/'.$record->batchInfo?->id.'/' . $record->email . '/' . $file;
                            //     return view('livewire.recruitment.step1.check-file.pdf-viewer', compact('link'));
                            // })
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                            ->modalWidth(MaxWidth::Full)
                            ->action(function () {
                            })->closeModalByClickingAway(false),
                        \Filament\Forms\Components\Actions\Action::make($status . '-check')
                            ->iconButton()
                            ->color(Color::Green)
                            ->icon('heroicon-o-check')
                            ->extraAttributes(['title' => 'Approved'])
                            ->action(function ($record) use ($status,  $label) {

                                \App\Models\ApplicantLog::create([
                                    'activity' => 'Approved by '.Auth::user()->name,
                                    'message'=>$label,
                                    'id_number' => Auth::user()->id_number,
                                    'applicant_id' => $record->id,
                                     'type'=>'1'
                                ]);


                                $record->update([$status => 1]);

                                return $record;
                            })
                            ->hidden(function($record) use($action){
                                if(Auth::user()->can('RECRUITMENT'))
                                {
                                    return  $record->application_status == 2 || $record->application_status == 4 || $action ? true : false;
                                }
                                if(Auth::user()->can('RECRUITMENT VIEW')) return true;

                            })
                           ,
                        \Filament\Forms\Components\Actions\Action::make($status . '-reject')
                            ->iconButton()
                            ->color(Color::Red)
                            ->extraAttributes(['title' => 'Reject'])
                            ->icon('heroicon-o-x-mark')
                            ->action(function ($record) use ($status, $label) {
                                \App\Models\ApplicantLog::create([
                                    'activity' => 'Reject by '.Auth::user()->name,
                                    'message'=>$label,
                                    'id_number' => Auth::user()->id_number,
                                    'applicant_id' => $record->id,
                                     'type'=>'2'
                                ]);

                                $record->update([$status => 2]);

                                return $record;
                            })
                            ->hidden(function($record) use($action){
                                if(Auth::user()->can('RECRUITMENT')){
                                    return $record->application_status == 2 || $record->application_status == 4 || $action ? true : false;
                                }
                                if(Auth::user()->can('RECRUITMENT VIEW')) return true;

                            })
                            ,
                    ])->extraAttributes(['style' => 'width:fit-content;margin-left:auto']),

                    Placeholder::make('dsasdad')->columnSpan(5)->label('')->content(function ($record) use ($label) {
                        $comments = $record->comments?->where('filename', $label);
                        return view('livewire.recruitment.comments', compact('comments', 'record'));
                    })->hidden($comment)
                ])
            ])->heading(false);
    }

}
