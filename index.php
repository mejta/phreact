<?php
include __DIR__ . '/vendor/autoload.php';

use Phreact\Document;

$document = new Document([
    ['html', [], [
        ['head', [], [
            ['title', [], ['Example title']],
            ['meta', [
                'content-type' => 'text/html;charset=utf-8',
            ]],
        ]],
        ['body', ['class' => 'body-class'], [
            ['h1', [], [function($props) {
                return 'Example heading in callable';
            }]],
            ['hr'],
            ['p', [], ['Example paragraph']]
        ]],
    ]],
]);

$document->render(true);
