<?php namespace Leadofficelist\Toolbox;

class Toolbox extends \BaseModel {
	protected $fillable = [ 'name', 'description', 'type', 'url', 'filename' ];
	protected $table = 'toolbox';

	public function addLink( $command ) {
		$link              = new Toolbox;
		$link->name        = $command->name;
		$link->description = $command->description;
		$link->type        = 'link';
		$link->url         = $command->url;
		$link->save();

		return $link;
	}

	public function addFile( $command ) {
		$file              = new Toolbox;
		$file->name        = $command->name;
		$file->description = $command->description;
		$file->type        = 'file';
		$file->file         = $command->file;
		$file->save();

		return $file;
	}

	public function editLink( $command ) {
		$updated_link              = Toolbox::find($command->id);
		$updated_link->name        = $command->name;
		$updated_link->description = $command->description;
		$updated_link->url         = $command->url;
		$updated_link->save();

		return $updated_link;
	}

	public function editFile( $command ) {
		$updated_file              = Toolbox::find($command->id);
		$updated_file->name        = $command->name;
		$updated_file->description = $command->description;
		$updated_file->save();

		return $updated_file;
	}
}