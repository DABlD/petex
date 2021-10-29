<?php

namespace App\Traits;

trait TransactionAttribute{

	public function getActionsAttribute(){
		if(auth()->user()->role != "Admin"){
			if($this->status == "To Process" || $this->status == "Rider Cancel"){
				return 	'<a class="btn btn-success" data-toggle="tooltip" title="Find Driver" data-id="' . $this->id . '">' .
					        '<span class="fa fa-search" data-id="' . $this->id . '"></span>' .
					   '</a>&nbsp;' . 
					   '<a class="btn btn-danger" data-toggle="tooltip" title="Cancel" data-status="' . $this->status . '" data-id="' . $this->id . '">' .
				   	        '<span class="fa fa-close" data-status="' . $this->status . '" data-id="' . $this->id . '"></span>' .
				   	    '</a>&nbsp;';
			}
			else if($this->status == "For Pickup"){
				return '<a class="btn btn-danger" data-toggle="tooltip" title="Cancel" data-status="' . $this->status . '" data-id="' . $this->id . '">' .
				   	        '<span class="fa fa-close" data-status="' . $this->status . '" data-id="' . $this->id . '"></span>' .
				   	    '</a>&nbsp;' . 
					   '<a class="btn btn-warning" data-toggle="tooltip" title="View Files" data-files=`' . $this->files . '`>' .
					        '<span class="fa fa-file" data-files=`' . $this->files . '`></span>' .
					   '</a>&nbsp;' .
					   '<a class="btn btn-info" data-toggle="tooltip" title="Check Driver Location" data-id="' . $this->tid . '">' .
				   	        '<span class="fa fa-search" data-id="' . $this->tid . '"></span>' .
				   	    '</a>&nbsp;';
			}
			else if($this->status == "For Delivery"){
				return 	'<a class="btn btn-success" data-toggle="tooltip" title="Already Picked-Up" data-id="' . $this->id . '">' .
					        '<span class="fa fa-hand-paper-o" data-id="' . $this->id . '"></span>' .
					   '</a>&nbsp;' . 
					   '<a class="btn btn-danger" data-toggle="tooltip" title="Cancel" data-status="' . $this->status . '" data-id="' . $this->id . '">' .
				   	        '<span class="fa fa-close" data-status="' . $this->status . '" data-id="' . $this->id . '"></span>' .
				   	    '</a>&nbsp;' . 
					   '<a class="btn btn-warning" data-toggle="tooltip" title="View Files" data-files=`' . $this->files . '`>' .
					        '<span class="fa fa-file" data-files=`' . $this->files . '`></span>' .
					   '</a>&nbsp;' .
					   '<a class="btn btn-info" data-toggle="tooltip" title="Check Driver Location" data-id="' . $this->tid . '">' .
				   	        '<span class="fa fa-search" data-id="' . $this->tid . '"></span>' .
				   	    '</a>&nbsp;';
			}
			else if($this->status == "Delivered"){
				return 	'<a class="btn btn-primary" data-toggle="tooltip" title="Rate Driver" data-id="' . $this->id . '" data-rating="' . $this->rating . '">' .
					        '<span class="fa fa-star" data-id="' . $this->id . '" data-rating="' . $this->rating . '"></span>' .
					   '</a>&nbsp;' .
					   '<a class="btn btn-info" data-toggle="tooltip" title="View Proof of Delivery" data-proof="' . $this->proof . '">' .
				   	        '<span class="fa fa-search" data-proof="' . $this->proof . '"></span>' .
				   	    '</a>&nbsp;';
			}
			else{
				return '<a class="btn btn-danger" data-toggle="tooltip" title="Cancel" data-status="' . $this->status . '" data-id="' . $this->id . '">' .
				   	        '<span class="fa fa-close" data-status="' . $this->status . '" data-id="' . $this->id . '"></span>' .
				   	    '</a>&nbsp;';
			}
				   // '<a class="btn btn-warning" data-toggle="tooltip" title="Edit User" data-id="' . $this->id . '">' .
				   //      '<span class="fa fa-pencil" data-id="' . $this->id . '"></span>' .
				   // '</a>&nbsp;'
		}
	}
}