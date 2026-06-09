<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_attempt
{
    protected $CI;
    protected $max_login_attempts   = 3; // Jumlah percobaan login yang diperbolehkan
    protected $time_interval        = 60; // Waktu jeda dalam detik

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('date');
    }

    /**
     * Set jumlah maksimum percobaan login
     * @param int $max_login_attempts Jumlah percobaan login yang diperbolehkan
     */
    public function set_max_login_attempts($max_login_attempts)
    {
        $this->max_login_attempts = $max_login_attempts;
    }

    /**
     * Set waktu jeda antara setiap percobaan login
     * @param int $time_interval Waktu jeda dalam detik
     */
    public function set_time_interval($time_interval)
    {
        $this->time_interval = $time_interval;
    }

    /**
     * Menghitung jumlah percobaan login yang telah dilakukan
     * @param string $username Nama pengguna
     * @return int Jumlah percobaan login yang telah dilakukan
     */
    public function get_login_attempts($username)
    {
        $login_attempts = $this->CI->session->userdata('login_attempts');
        if (!isset($login_attempts[$username])) {
            return 0;
        }
        return $login_attempts[$username]['attempts'];
    }

    /**
     * Mengembalikan waktu terakhir percobaan login
     * @param string $username Nama pengguna
     * @return int Waktu terakhir percobaan login dalam detik
     */
    public function get_last_login_attempt($username)
    {
        $login_attempts = $this->CI->session->userdata('login_attempts');
        if (!isset($login_attempts[$username])) {
            return 0;
        }
        return $login_attempts[$username]['time'];
    }

    /**
     * Menambah jumlah percobaan login untuk pengguna tertentu
     * @param string $username Nama pengguna
     */
    public function increment_login_attempts($username)
    {
        $login_attempts = $this->CI->session->userdata('login_attempts');
        $now = now();

        if (!isset($login_attempts[$username])) {
            $login_attempts[$username] = array(
                'attempts' => 1,
                'time' => $now
            );
        } else {
            $login_attempts[$username]['attempts']++;
            $login_attempts[$username]['time'] = $now;
        }

        $this->CI->session->set_userdata('login_attempts', $login_attempts);
    }

    /**
     * Reset jumlah percobaan login untuk pengguna tertentu
     * @param string $username Nama pengguna
     */
    public function reset_login_attempts($username)
    {
        $login_attempts = $this->CI->session->userdata('login_attempts');
        unset($login_attempts[$username]);
        $this->CI->session->set_userdata('login_attempts', $login_attempts);
    }

    /**
     * Mengecek apakah jumlah maksimum percobaan login telah tercapai untuk pengguna tertentu
     * @param string $username Nama pengguna
     * @return
    * maksimum percobaan login telah tercapai, FALSE jika tidak
    */

    public function is_max_login_attempts_exceeded($username)
    {
        $login_attempts = $this->CI->session->userdata('login_attempts');
        if (!isset($login_attempts[$username])) {
            return FALSE;
        }

        $attempts = $login_attempts[$username]['attempts'];
        $last_attempt = $login_attempts[$username]['time'];

        if ($attempts >= $this->max_login_attempts) {
            if (now() - $last_attempt < $this->time_interval) {
                return TRUE;
            } else {
                $this->reset_login_attempts($username);
                return FALSE;
            }
        }

        return FALSE;
    }
}
