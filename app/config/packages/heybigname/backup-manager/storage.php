<?php

return [
    'local' => [
        'type' => 'Local',
        'root' => '/home/vagrant/www/ag-aus/app/storage/backups',
    ],
    's3' => [
        'type' => 'AwsS3',
        'key'    => Config::get('keys.amazon.aws_key'),
        'secret' => Config::get('keys.amazon.aws_secret'),
        'region' => Aws\Common\Enum\Region::AP_SOUTHEAST_2,
        'bucket' => 'alternative-gaming',
        'root'   => 'mysql-backups',
    ],
];
