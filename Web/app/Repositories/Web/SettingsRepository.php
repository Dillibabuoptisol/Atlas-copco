<?php
/**
 * Settings Repository
 *
 * To manage the functionalities related to the settings module
 * @name       SettingsRepository
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories\Web;

use Admin\Models\Setting;
use Admin\Models\SettingCategory;
use Contus\Base\Repositories\Repository;

class SettingsRepository extends Repository {
    /**
     * Class property to hold the key which hold the settings object
     *
     * @var object
     */
    protected $_settings;
    
    /**
     * Class property to hold the key which hold the settings category object
     *
     * @var object
     */
    protected $_settingCategory;
    
    /**
     * Construct method
     */
    public function __construct(Setting $setting, SettingCategory $settingCategory) {
        parent::__construct ();
        $this->_settings = $setting;
        $this->_settingCategory = $settingCategory;
    }
    
    /**
     * Fetch settings to display in admin block.
     *
     * @return response
     */
    public function getSettings() {
        return $this->_settingCategory->with ( [ 
                'category',
                'category.settings' 
        ] )->where ( 'parent_id', NULL )->get ();
    }
    
    /**
     * Fetch setting categories to display in admin block.
     *
     * @return response
     */
    public function getSettingCategory() {
        return $this->_settingCategory->where ( 'parent_id', NULL )->get ();
    }
    
    /**
     * Update the settings based on the inputs
     *
     * @return response
     */
    public function updateSettings() {
        $this->generateDynamicRules ();
        $this->validate ( $this->request, $this->getRules () );        
        foreach ( $this->request->except ( '_token' ) as $key => $value ) {
            $split = explode ( '__', $key );
            $settingCategory = $this->_settingCategory->where ( 'slug', $split [0] )->first ();
            $setting = $this->_settings->where ( 'setting_name', $split [1] )->where ( 'setting_category_id', $settingCategory->id )->first ();            
            if (isset ( $setting ) && count ( $setting ) > 0) {
                if ($setting->type == 'image') {
                    $this->__imageUpload ( $setting, $settingCategory );
                }
                $setting->setting_value = ($setting->type == 'image') ? $setting->setting_value : $value;
                $setting->save ();
            }
        }
        $this->generateSettingsCache ();
        return true;
    }
    
    /**
     * To generate cache file after updating the setting records.
     *
     * Cache file path configured in config file. Once the setting data updated the JSON file will be generated.
     *
     * @return response
     */
    public function generateSettingsCache() {
        $fileSystem = app ()->make ( 'files' );
        $settingDetails = $this->getSettings ();
        $siteSettingPath = storage_path ( 'app' . DIRECTORY_SEPARATOR . 'sitesettings.json' );
        $result = [ ];
        foreach ( $settingDetails as $settingDetail ) {
            foreach ( $settingDetail ['category'] as $category ) {
                foreach ( $category ['settings'] as $setting ) {
                    $result [$settingDetail->slug] [$category->slug] [$setting->setting_name] = $setting->setting_value;
                }
            }
        }
        $fileSystem->delete ( $siteSettingPath );
        
        if (! $fileSystem->exists ( $siteSettingPath )) {
            $fileSystem->put ( $siteSettingPath, json_encode ( $result ) );
        }
    }
    
    /**
     * To generate cache file for validation rule.
     *
     * All the validation rule will be generated as JSON file .
     *
     * @return response
     */
    public function generateValidationCache() {
        $fileSystem = app ()->make ( 'files' );
        $siteTranslationPath = public_path ( 'assets' . DIRECTORY_SEPARATOR . 'locale' ) . '/translation_en.json';
        
        $fileSystem->delete ( $siteTranslationPath );
        
        if (! $fileSystem->exists ( $siteTranslationPath )) {
            $fileSystem->put ( $siteTranslationPath, json_encode ( trans ( 'validation' ) ) );
        }
    }
    
    /**
     * Generate validation rule for settings data
     *
     * All the fileds required. Form validation rule and set that rule
     *
     * @return response
     */
    public function generateDynamicRules() {
        $rules = [ ];
        foreach ( $this->request->except ( '_token' ) as $key => $value ) {
            if (strpos ( $key, 'site_fav_icon' ) !== false || strpos ( $key, 'site_logo' ) !== false) {
                $rules [$key] = 'required|mimes:png|max:1000';
            } else {
                $rules [$key] = 'required';
            }
        }
        return $this->setRules ( $rules );
    }
    
    /**
     * Method is used to upload image for all process in settings
     *
     * @param $setting, $settingCategory            
     *
     * @return boolean
     */
    public function __imageUpload($setting, $settingCategory) {
        $fieldName = $settingCategory->slug . '__' . $setting->setting_name;
        if (isset ( $this->request [$fieldName] ) && ! empty ( $this->request [$fieldName] )) {
            $destinationPath = public_path () . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images';
            if ($this->request [$fieldName]->move ( $destinationPath, $setting->setting_name . ".png" )) {
                return true;
            }
        }
    }
}