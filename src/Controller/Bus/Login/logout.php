<?php

if ($this->Auth->logout()) {
    return $this->redirect('/login');
}
