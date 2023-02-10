<?php

/**
 * Implements of Model
 *
 *
 * @name Model
 * @vendor Contus
 * @package Base
 * @version 1.0
 * @author Contus<developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base;

use Illuminate\Database\Eloquent\Model as IlluminateModel;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class Model extends IlluminateModel {
    /**
     * The request registered on Base Repository.
     *
     * @var object
     */
    private $request;

    /**
     * Constructor method
     * sets hidden for customers
     */
    public function __construct() {
        parent::__construct ();
        $this->request = app ()->make ( 'request' );
    }
    /**
     * Set the hidden attributes for the model based on user.
     *
     * @param array $hidden
     * @return $this
     */
    public function setHiddenCustomer(array $hidden) {
        if (Config::get ( 'auth.table' ) === 'customers') {
            if (($this->request->header ( 'x-request-type' ) == 'mobile') && (($key = array_search ( 'id', $hidden )) !== false)) {
                unset ( $hidden [$key] );
            }
            $this->hidden = $hidden;
        }
        return $this;
    }

    /**
     * Set the visible attributes for the model based on user.
     *
     * @param array $visible
     * @return $this
     */
    public function setVisibleCustomer(array $visible) {
        if (Config::get ( 'auth.table' ) === 'customers') {
            $this->visible = $visible;
        }
        return $this;
    }
    /**
     * Dynamic slug update
     *
     * @param string $createSlugFrom
     * @param string $thisSlug
     */
    public function setDynamicSlug($createSlugFrom, $thisSlug = 'slug') {
        $slug = str_slug ( $this->$createSlugFrom );
        if ($slug) {
            $count = (! empty ( $this->getKey () )) ? $this->where ( $this->getKeyName (), '!=', $this->getKey () ) : '';
            $count = $this->where ( $thisSlug, 'like', $slug )->count ();
            $this->$thisSlug = ($count) ? $slug . '-' . $count : $slug;
        }
    }
    /**
     * Set Dynamic Date formate for created at mobile resoponse
     *
     * @param string $date
     * @return string
     */
    public function getCreatedAtAttribute($date) {
        return $this->getFormatedDateCustomer ( $date );
    }
    /**
     * Set Dynamic Date formate for updated at mobile resoponse
     *
     * @param string $date
     * @return string
     */
    public function getUpdatedAtAttribute($date) {
        return $this->getFormatedDateCustomer ( $date );
    }
    /**
     * Set Dynamic Dateformate for mobile
     *
     * @param string $date
     * @return string
     */
    private function getFormatedDateCustomer($date) {
        if ($this->request->header ( 'x-request-type' ) == 'mobile') {
            return Carbon::createFromFormat ( 'Y-m-d H:i:s', $date )->format ( 'M jS Y, g:i A' );
        } else {
            return (strtotime($date))?Carbon::createFromFormat ( 'Y-m-d H:i:s', $date )->format ( 'Y-m-d H:i:s' ):$date;
        }
    }
    /**
     * Set Default condition for frontend customer
     *
     * @return object
     */
    public function whereCustomer() {
        if (Config::get ( 'auth.table' ) === 'customers') {
            return $this->where ( 'is_active', '1' );
        }
    }
}
