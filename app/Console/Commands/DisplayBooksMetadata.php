<?php 
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\ElibriApiService;

class DisplayBooksMetadata extends Command {
protected $signature = 'display:books-metadata';
protected $description = 'Display books metadata from Elibri API';

    private $elibriService;

    public function __construct(ElibriApiService $elibriService) {
        parent::__construct();
        $this->elibriService = $elibriService;
    }


    public function handle() {
    $page = 1;

    while (true) {
        $metadata = $this->elibriService->getAllBooks($page);

        if ($metadata === null || empty($metadata->Product)) {
            $this->error('No more data received from API.');
            break;
        }

        foreach ($metadata->Product as $product) {
            $productForm = (string)$product->DescriptiveDetail->ProductForm;
            if ($productForm === 'EA') continue;

	$title = null;

if (isset($product->DescriptiveDetail->TitleDetail)) {
    foreach ($product->DescriptiveDetail->TitleDetail as $titleDetail) {
        // Sprawdzanie, czy TitleType to '01'
        if ((string)$titleDetail->TitleType === '01' && isset($titleDetail->TitleElement)) {
            foreach ($titleDetail->TitleElement as $element) {
                // Sprawdzanie, czy TitleElementLevel to '01'
                if ((string)$element->TitleElementLevel === '01') {
                    // Pobieranie TitleText
                    $title = (string)$element->TitleText;
                    break 2; // Znaleziono odpowiedni tytuł, przerywamy obie pętle
                }
            }
        }
    }
}
            
            
            $ean = (string)$product->ProductIdentifier->IDValue;
            $price = (string)$product->ProductSupply->SupplyDetail->Price->PriceAmount;
            
            
            //$authorName = $product->DescriptiveDetail->Contributor ? (string)$product->DescriptiveDetail->Contributor->PersonName : 'Brak autora';
            
            $authorName = 'Brak autora'; // Domyślna wartość
            if (isset($product->DescriptiveDetail->Contributor) && isset($product->DescriptiveDetail->Contributor->PersonName)) 
            {   $authorName = (string)$product->DescriptiveDetail->Contributor->PersonName; 
			}
            
            
            
            $publishingDate = isset($product->PublishingDetail->PublishingDate) ? (string)$product->PublishingDetail->PublishingDate->Date : null;

            if ($publishingDate && strlen($publishingDate) === 4) {
                $publishingDate .= '-01-01';
            } elseif (!$publishingDate || !strtotime($publishingDate)) {
                $publishingDate = null;
            }

            \App\Models\Book::updateOrCreate(
                ['ean' => $ean],
                [
                    'title' => $title,
                    'price' => $price,
                    'author' => $authorName,
                    'publishing_date' => $publishingDate,
                    'product_form' => $productForm
                ]
            );
        }
    
        $page++;
    }

    $this->info("Import danych zakończony.");
}



    }

