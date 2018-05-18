<?php
$transform = [
    'name' => 'scale',
    'start' => '(1.1, 1.1)',
    'end' => '(1, 1)',
];
?>
<html>
    <head>
        <title>G5</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <style>
            .gm-field-cell {
                border: 1px solid #000;
                width: 50px;
                height: 50px;
                text-align: center;
                vertical-align: middle;
            }

            .gm-field-player {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: 1px solid #f0f0f0;
            }

            .gm-field-snag {
                width: 40px;
                height: 40px;
            }

            @keyframes slideInFromLeft {
                0% {
                    transform: <?=$transform['name'] . $transform['start']?>;
                }
                100% {
                    transform: <?=$transform['name'] . $transform['end']?>;
                }
            }

            .gm-field-player img {
                animation: 1s ease-out 0s 1 slideInFromLeft;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card text-center">
                <div class="card-header">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="#">Navbar will be here</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <?=$content??'Use content, Luke!'?>
                </div>
                <div class="card-footer">
                    footer will be here
                </div>
            </div>
        </div>
    </body>
</html>