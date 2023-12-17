<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Secrets extends BaseConfig
{ 

    // Leave empty if you pefer just password.
    // The password will be authenticated with this orded:
    // -- saved password from the database
    // -- your prefered authentication method.

    // Change to `ldap` to use LDAP.
    public $shj_authenticate = 'radius';

    public $shj_radius = [
        "server" => "localhost",
        "secret" => "i-have-no-secret"
    ];

    // LDAP Settings reffers to
    // @link https://adldap2.github.io/Adldap2/#/setup?id=options
    public $shj_ldap = [
        "hosts" => ["dc3.ftis.unpar"],
        "base_dn" => "DC=FTIS,DC=UNPAR",
        "username"=> "",
        "password"=> "",
        "account_suffix"   => "@ftis.unpar"
    ];

    public $shj_mail = [
        'protocol' => 'smtp',
        'SMTPHost' => 'smtp.gmail.com',
        'SMTPPort' => 587,
        'SMTPUser' => '',
        'SMTPPass' => '',
        'mailType'  => 'html',
        'charset'   => 'utf-8'
    ];
}
