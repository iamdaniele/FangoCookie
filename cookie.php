<?php
/**
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @author Daniel Bernardi <taniele.billini@gmail.com>
* @link http://github.com/dbernardi/FangoCookie
*/
class Cookie {

    protected $name = "cookie";
    protected $expiration;
    protected $content = array();

    public function __construct($name = null, $expiration = null) {

        $this->name = $name != null ? $name : $this->name;
        $this->expiration = $expiration != null ? $expiration : null;
    }

    public function set($key, $value) {

        $this->content[$key] = $value;
        $this->writeCookie();
    }

    protected function writeCookie() {

        $cookie = json_encode($this->content);
        
        setrawcookie($this->name, $cookie, $this->expiration, "/", $_SERVER["HOST_NAME"]);
    }

    public function get($key) {
        
        $cookie = json_decode(stripslashes($_COOKIE[$this->name]), true);
        if(is_array($cookie) && array_key_exists($key, $cookie)) {
            return $cookie[$key];
        }
        else return null;
    }

    public function delete($key) {
        
        if(array_key_exists($key, $this->content)) {
            unset($this->content[$key]);
            $this->writeCookie;
            return true;
        }
        else return false;
    }

    public function destroy() {

        $this->content = array();
        setrawcookie($this->name, "", time() - 3600, "/", $_SERVER["HOST_NAME"]);

        if(isset($_COOKIE[$this->name])) {
            unset($_COOKIE[$this->name]);
        }
    }
}

?>
