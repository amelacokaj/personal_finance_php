<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BaseController extends Controller 
{
	public function __construct()
	{
		//$this->middleware('auth.admin');
	}
	
	public function uploadFiles($request, $file_input_name, $image_size='', $small_size='', $thumb_size='')
	{
		$resp = ['code'=>500];
		
		if($request->hasFile($file_input_name) && $request->file($file_input_name)->isValid() )
		{
			try {
				//http://image.intervention.io/
				$file = $request->file($file_input_name);
				$destinationPath = 'images/uploads';
				// If the uploads fail due to file system, you can try doing public_path().'/uploads'
				$filename = str_random(5).time().'.'.$file->getClientOriginalExtension();
				//make thumbnail
				if($thumb_size != '')
				{
					$size = explode('x', $thumb_size);
					\Image::make($file->getRealPath())->fit($size[0], $size[1])->save($destinationPath.'/thumb/'.$filename);					
				}
				
				if($small_size != '')
				{
					$size = explode('x', $small_size);
					$img = \Image::make($file->getRealPath());
					$img->resize($size[0], $size[1], function ($constraint) {
						$constraint->aspectRatio();
						$constraint->upsize();
					});
					$img->save($destinationPath.'/small/'.$filename);
				}
				
				if($image_size != '')
				{	
					$size = explode('x', $image_size);
					$img = \Image::make($file->getRealPath());
					$img->resize($size[0], $size[1], function ($constraint) {
						$constraint->aspectRatio();
						$constraint->upsize();
					});
					$img->save($destinationPath.'/'.$filename);
				}
				else 
				{
					//move the original uploaded file
					$upload_success = $file->move($destinationPath, $filename);
					if(!$upload_success) {
						throw new \Exception('Error_uploading_file');
					}
				}
				
				$resp = ['code'=>200, 'filename'=>$filename, 'dir_path'=>$destinationPath];
			}
			catch (\Exception $e)
			{
				info($e->getMessage(), [$e->getLine()]);
			}
		}
		else
		{
			$resp = ['code'=>202];
		}
		
		return $resp;
	}
}
