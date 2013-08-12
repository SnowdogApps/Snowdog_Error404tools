<?php

    $installer = $this;

    $installer->startSetup();
    $conn   = $installer->getConnection();

    $conn->addColumn($this->getTable('fourzerofour/log'), 'ip_address', 'VARCHAR(255) not null');
    $conn->addColumn($this->getTable('fourzerofour/log'), 'user_agent', 'VARCHAR(255) not null');

    $installer->endSetup();