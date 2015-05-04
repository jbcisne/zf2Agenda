<?php
return array(
    'caches' => array(
        'Cache\FileSystem' => array(
            'adapter'   => 'filesystem',
            'options'   => array(
                'cache_dir' => __DIR__ . '/../../data/cache/'
            ),
            'plugins' => array(
                'exception_handler' => array(
                    'throw_exceptions' => false,
                ),
                'Serializer'
            ),
        ),
    ),
);