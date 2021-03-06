<?php
namespace Mvd81\LaravelIsAdmin\Traits;

trait isAdmin {

    public function isAdmin() {
        return $this->is_admin
            || (config()->has('is_admin.use_super_admin')
                && config('is_admin.use_super_admin')
                && $this->id == 1);
    }

    public function makeAdmin() {
        if ($this->id > 0) {
            $this->update(['is_admin' => 1]);
        }
    }

    public function undoAdmin() {
        if ($this->id > 0) {
            $this->update(['is_admin' => 0]);
        }
    }


}
