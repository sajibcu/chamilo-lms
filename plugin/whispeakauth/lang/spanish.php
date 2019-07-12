<?php
/* For licensing terms, see /license.txt */

$strings['plugin_title'] = 'Authenticación de voz con Whispeak';
$strings['plugin_comment'] = 'Permitir autenticación de voz en Chamilo.';

$strings['enable'] = 'Habilitar';
$strings['enable_help'] = '<p>Agrega <code>$_configuration[\'whispeak_auth_enabled\'] = true;</code> al archivo <code>configuration.php</code></p>';
$strings['api_url'] = 'URL del API';
$strings['api_url_help'] = 'http://api.whispeak.io:8080/v1/';
$strings['token'] = 'Llave del API';
$strings['max_attempts'] = 'Máximo de intentos';
$strings['max_attempts_help'] = '(Opcional) Si la autenticación de Whispeak falla x intentos, preguntar y verificar la contraseña del usuario';
$strings['2fa'] = 'Autenticación en dos factores';
$strings['2fa_help'] = 'Permite extender la página de inicio de sesión con un proceso de dos factores. Después del inicio de sesión clásico, el usuario deberá autenticarse a través de Whispeak.';

$strings['EnrollmentSampleText'] = 'El famoso cuadro de Mona Lisa fue pintado por Leonardo Da Vinci.';
$strings['AuthentifySampleText1'] = 'Cayendo como moscas.';
$strings['AuthentifySampleText2'] = 'Mantén tus ojos abiertos.';
$strings['AuthentifySampleText3'] = 'El zorro grita a medianoche.';
$strings['AuthentifySampleText4'] = 'Ir por las ramas.';
$strings['AuthentifySampleText5'] = 'Debajo del agua.';
$strings['AuthentifySampleText6'] = 'Ladrando al árbol equivocado.';

$strings['RepeatThisPhrase'] = 'Repita esta frase tres veces después de permitir la grabación de audio:';
$strings['EnrollmentSignature0'] = 'Firma insostenible, requiere una nueva inscripción.';
$strings['EnrollmentSignature1'] = 'Firma aceptable, pero se aconseja hacer una nueva inscripción.';
$strings['EnrollmentSignature2'] = 'Firma correcta.';
$strings['EnrollmentSignature3'] = 'Buena firma.';
$strings['SpeechAuthAlreadyEnrolled'] = 'Autenticación de voz registrada anteriormente.';
$strings['SpeechAuthNotEnrolled'] = 'Autenticación de voz no registrada previamente.';
$strings['SpeechAuthentication'] = 'Atenticación con voz';
$strings['EnrollmentFailed'] = 'Inscripción fallida.';
$strings['EnrollmentSuccess'] = 'Inscripción correcta.';
$strings['AuthentifyFailed'] = 'Inicio de sesión fallido.';
$strings['AuthentifySuccess'] = '¡Autenticación correcta!';
$strings['TryAgain'] = 'Intente de nuevo.';
$strings['MaxAttemptsReached'] = 'Ha alcanzado el número máximo de intentos permitidos.';
$strings['LoginWithUsernameAndPassword'] = 'Debe iniciar sesión usando su nombre de usuario y contraseña.';

$strings['AudioQualityShort'] = 'Audio demasiado corto';
$strings['AudioQualityQuiet'] = 'Audio demasiado silencioso';
$strings['AudioQualityLoud'] = 'Audio demasiado alto';
$strings['AudioQualityNoisy'] = 'Audio demasiado ruidoso';
$strings['AudioQualityFrequency'] = 'Falta algunas frecuencias de audio';
$strings['AudioQualityPoorness'] = 'Calidad de audio general demasiado pobre';

$strings['AgreeAllowResearch'] = 'Estoy de acuerdo en permitir el uso de datos para investigación (no uso comercial).';

$strings['MarkForSpeechAuthentication'] = 'Marcar elemento para autenticación con voz';
