<?php
/*
(c) Copyright 2012 X.commerce, Inc.

All rights reserved. No part of this code shall be reproduced,
stored in a retrieval system, or transmitted by any means,
electronic, mechanical, photocopying, recording, or otherwise,
without written permission from X.commerce, Inc.  04-15-2012

Please be aware that this code is not production ready.
It is distributed to serve as an educational example, but in
some cases error checking or something similar might have been
neglected.
*/

class Snowdog_Fourzerofour_Model_Resource_Log_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct() {

        parent::_construct();
        $this->_init('fourzerofour/log', 'log_id');
    }

}