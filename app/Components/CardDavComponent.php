<?php

namespace App\Components;

use JeroenDesloovere\VCard\VCardParser;
use Sabre\DAV\Client;
use Sabre\Xml\ParseException;
use XMLWriter;

class CardDavComponent
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'baseUri' => getenv('DAV_BASE_URI'),
            'userName' => getenv('DAV_USERNAME'),
            'password' => getenv('DAV_PASSWORD'),
        ]);
    }

    public function getAll(): array
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('C:addressbook-query');
        $xml->writeAttribute('xmlns:D', 'DAV:');
        $xml->writeAttribute('xmlns:C', 'urn:ietf:params:xml:ns:carddav');
        $xml->startElement('D:prop');
        $xml->writeElement('C:address-data');
        $xml->endElement();
        $xml->endElement();

        $r = $this->client->request('REPORT', getenv('DAV_BOOK_PATH'), $xml->outputMemory(), [
            'Depth' => '1',
            'Content-Type' => 'application/xml',
        ]);

        return $this->parse($r['body']);
    }

    private function parse(string $body): array
    {
        /** @var \Sabre\DAV\Xml\Response\MultiStatus $multistatus */
        try {
            $multistatus = $this->client->xml->expect('{DAV:}multistatus', $body);
        } catch (ParseException $e) {
            return [];
        }

        $result = [];

        foreach ($multistatus->getResponses() as $response) {
            $vcard = head($response->getResponseProperties()[200]);

            $result = array_merge($result, (new VCardParser($vcard))->getCards());
        }

        return $result;
    }
}
