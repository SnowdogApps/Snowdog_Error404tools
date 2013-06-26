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

class Snowdog_Fourzerofour_Model_Log_Type  {

    public function toOptionArray() {
        return array(
            array('value'=>1, 'label'=>Mage::helper('fourzerofour')->__('Database')),
            array('value'=>2, 'label'=>Mage::helper('fourzerofour')->__('Database + Log file')),
            array('value'=>3, 'label'=>Mage::helper('fourzerofour')->__('Log file')),

        );
    }
}