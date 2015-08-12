<?php

function reportError($message) {

    mail('WEBMASTER_EMAIL', 'Error on PTSHome script', $message);

}