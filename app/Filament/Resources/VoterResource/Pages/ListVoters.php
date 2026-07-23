<?php

namespace App\Filament\Resources\VoterResource\Pages;

use App\Filament\Resources\VoterResource;
use App\Imports\VotersImport;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ListVoters extends ListRecords
{
    protected static string $resource = VoterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('importExcel')
                ->label('Import Excel DPT')
                ->icon('heroicon-o-document-arrow-up')
                ->color('success')
                ->modalHeading('Import Data DPT dari File Excel')
                ->modalDescription('Unggah file Excel (.xlsx / .csv) berisi daftar pemilih tetap Desa Pikat.')
                ->form([
                    Forms\Components\FileUpload::make('attachment')
                        ->label('Pilih File Excel (.xlsx / .csv)')
                        ->disk('local')
                        ->directory('imports')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $filePath = Storage::disk('local')->path($data['attachment']);

                    try {
                        $import = new VotersImport();
                        Excel::import($import, $filePath);

                        Notification::make()
                            ->title('Berhasil Import Data DPT')
                            ->body('Seluruh data dari file Excel telah berhasil diunggah dan disimpan.')
                            ->success()
                            ->send();
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Gagal Mengimpor Excel')
                            ->body('Terjadi kesalahan saat memproses file: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\CreateAction::make()
                ->label('Tambah Pemilih Manual'),
        ];
    }
}
