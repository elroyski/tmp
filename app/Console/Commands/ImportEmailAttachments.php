<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RaportyEmpikuImport;
use Illuminate\Support\Facades\Mail;

class ImportEmailAttachments extends Command {
    protected $signature = 'import:email-attachments';
    protected $description = 'Importuje załączniki e-mail';

    public function handle() {
        Log::info('Rozpoczęcie importu e-maili.');

        $cm = new ClientManager();
        $client = $cm->make([
            'host'  => 'mail11.mydevil.net',
            'port'  => 993,
            'encryption'    => 'ssl',
            'validate_cert' => false,
            'username' => 'wsqn@wsqn.usermd.net',
            'password' => 'Kochanapysia1',
            'protocol' => 'imap'
        ]);

 if (!$client->connect()) {
            Log::error('Nie można połączyć z serwerem IMAP.');
            return;
        }

$today = now()->format('Y-m-d');
$folder = $client->getFolder('INBOX');
$messages = $folder->query()->subject('Raport z hurtowni danych Empik')->get();

$found = false;

foreach ($messages as $message) {
    $messageDate = new \DateTime($message->getDate());
    if ($messageDate->format('Y-m-d') === $today) {
        foreach ($message->getAttachments() as $attachment) {
            if ($attachment->getName() === 'DlaDostawcow4.csv') {
                $todayFilename = 'empik/' . $today . '_' . $attachment->getName();
                if (!Storage::disk('local')->exists($todayFilename)) {
                    Storage::disk('local')->put($todayFilename, $attachment->getContent());
                    Log::info('Zapisano plik: ' . $todayFilename);

                    $reportDate = now()->subDay()->format('Y-m-d');
                    $import = new RaportyEmpikuImport($reportDate);
                    Excel::import($import, storage_path('app/' . $todayFilename));
                    Log::info('Zaimportowano dane z pliku: ' . $todayFilename);
                    $found = true;
                    break; // Przerwij pętlę po zaimportowaniu pliku
                } else {
                    Log::info('Plik z dnia ' . $today . ' już istnieje.');
                }
            }
        }
        if ($found) break; // 
    }
}



        if (!$found) {
			Mail::send('emails.missingFile', ['date' => $today], function ($message) {
				$message->to('tomasz.wojcik@wsqn.pl')
					->to('tomasz.nowinski@wsqn.pl')
					->subject('Brakujący plik raportu Empik');
				
			});
            Log::info('E-mail o braku pliku został wysłany.');
        }

        $client->disconnect();
        Log::info('Zakończono import e-maili.');
    }
}