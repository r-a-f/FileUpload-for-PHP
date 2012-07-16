Upload Class
------------
A simple PHP class to upload files.

Example #1:
------------
    *PHP FILE*
```php
    <?php
    	$upload = new upload;
    	$upload->set( 'file_input' , '/var/www/uploads/' , 'images' );
    	$data = $upload->upload();
    	print_r( $data );
    ?>
```
    *HTML FILE*
```html
    <form>
    	<input type="file_input" name="file" />
    	<input type="submit" value="Upload" />
    </form>
```



Example #2:
------------
    *PHP FILE*
```php
    <?php
    	$upload = new upload;
    	$upload->set( 'file_input' , '/var/www/uploads/' , 'videos' );
    	$upload->encode_name( true );
    	$data = $upload->upload();
    	print_r( $data );
    ?>
```
    *HTML FILE*
```html
    <form>
    	<input type="file_input" name="file" />
    	<input type="submit" value="Upload" />
    </form>
```


Example #3:
------------
    *PHP FILE*
```php
    <?php
    	$upload = new upload;
    	$upload->set( 'file_input' , '/var/www/uploads/' , 'images' , 'output_name' );
    	$data = $upload->upload();
    	print_r( $data );
    ?>
```
    *HTML FILE*
```html
    <form>
    	<input type="file_input" name="file" />
    	<input type="submit" value="Upload" />
    </form>
```


Documentation:
------------

* **set( string $fieldName , string $path [, mixed $allowMimes = null [, string $ouputname = null ] ] )**

    *Set field name*
    
* **encode_name([ bool $bool = true ] )**

    *Encode name*
    
* **upload(  )**

    *Upload file(s) and returns data output*