<?php

namespace App\Traits;

trait TransactionAttribute{

	public function getActionsAttribute(){
		return 	'<a class="btn btn-success" data-toggle="tooltip" title="Find Driver" data-id="' . $this->id . '">' .
			        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
			   '</a>&nbsp;' . 
				'<a class="btn btn-danger" data-toggle="tooltip" title="Cancel" data-id="' . $this->id . '">' .
			        '<span class="fa fa-close" data-id="' . $this->id . '"></span>' .
			    '</a>&nbsp;'
			   // '<a class="btn btn-warning" data-toggle="tooltip" title="Edit User" data-id="' . $this->id . '">' .
			   //      '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
			   // '</a>&nbsp;'
			   ;
	}
}