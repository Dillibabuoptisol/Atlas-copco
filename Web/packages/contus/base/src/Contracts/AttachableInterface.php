<?php
/**
 * Implements of AttachableInterface
 * 
 * @name       AttachableInterface
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Contracts;

interface AttachableInterface {
    /**
     * Get File Information Model
     * the model related for holding the uploaded file information
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getFileModel();
}
