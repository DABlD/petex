<?php

namespace App\Traits;

trait UserAttribute{

	public function getFullNameAttribute(){
		return ucfirst($this->fname) . ' ' . ucfirst($this->lname);
	}

	public function getActionsAttribute(){
		$attr = '<a class="btn btn-success" data-toggle="tooltip" title="View User" data-id="' . $this->id . '">' .
			        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' .
			   '<a class="btn btn-warning" data-toggle="tooltip" title="View Files" data-files=`' . $this->files . '`>' .
			        '<span class="fa fa-file" data-files=`' . $this->files . '`></span>' .
			   '</a>&nbsp;';
			   // '<a class="btn btn-primary" data-toggle="tooltip" title="Edit User" data-id="' . $this->id . '">' .
			   //      '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
			   // '</a>&nbsp;' .;

		if($this->email_verified_at == null){
			$attr .= '<a class="btn btn-success" data-toggle="tooltip" title="Activate User" data-id="' . $this->id . '">' .
			     '<span class="fa fa-check" data-id="' . $this->id . '"></span>' .
			'</a>';
		}
		else{
			$attr .= '<a class="btn btn-danger" data-toggle="tooltip" title="Disable User" data-id="' . $this->id . '">' .
			     '<span class="fa fa-times-circle" data-id="' . $this->id . '"></span>' .
			'</a>';
		}

		return $attr;
	}
}