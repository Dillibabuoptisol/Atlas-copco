<?php
/**
 * Settings Controller
 *
 * To manage admin settings related actions.
 *
 * @name       Settings Controller
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Web;

use Contus\Base\Controllers\Controller;
use Admin\Repositories\Web\SettingsRepository;

class SettingsController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingsRepository $settings) {
        $this->_settingsRepository = $settings;
        $this->_settingsRepository->setRequestType ( 'HTTP' );
        $this->request = app ( 'request' );
        view ()->share ( 'includeAngularNotification', false );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\View
     */
    public function getIndex() {
        return view ( 'settings.settings', [ 
                'settingsField' => $this->_settingsRepository->getSettings (),
                'settingCategories' => $this->_settingsRepository->getSettingCategory () 
        ] );
    }
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate() {
        $this->_settingsRepository->updateSettings ();
        $this->request->session ()->flash ( 'success', trans ( 'general.settings-updated' ) );
        return redirect ( SETTINGS_TEMPLATE )->with ( 'success', trans ( 'general.settings-updated' ) );
    }
}