<?php
/* If run from a browser, exit. */
if ( php_sapi_name() != 'cli' ) exit;

/* Include necessary files */
require( dirname( __FILE__ ) . '/class/AdminPageFramework_Minifiler_ProgressBuffer.php' );
require( dirname( __FILE__ ) . '/class/AdminPageFramework_Minifier.php' );

/* Set necessary paths */
	
	/* Set the source path */
	$sSourceFilePath = dirname( dirname( __FILE__ ) ) . '/development/admin-page-framework.php';
	
	/* Set the location for the script output */
	$sResultFilePath = dirname( dirname( __FILE__ ) ) . '/library/admin-page-framework.min.php';
	
	/* Check the file existence. */
	if ( ! file_exists( $sSourceFilePath ) ) die( '<p>The main library file does not exist.</p>' );
	
	/* Check the permission to write. */
	if ( 
		( file_exists( $sResultFilePath ) && ! is_writable( $sResultFilePath ) )
		|| ! is_writable( dirname( $sResultFilePath ) ) 	
	) 
		die( sprintf( '<p>The permission denied. Make sure if the folder, %1$s, allows to modify/create a file.</p>', dirname( $sResultFilePath ) ) );
	
/* Echo progress report. */	
$oProgressBuffer = new AdminPageFramework_Minifiler_ProgressBuffer( 'Admin Page Framework Minifier Script' );	
$oProgressBuffer->showText( 'Starting...' );
	
/* Store all the script data in to an array */
$oProgressBuffer->showText( 'Reading files...' );


/* Write to a file */
$oMinify = new AdminPageFramework_Minifier( $sSourceFilePath, $sResultFilePath );
$oProgressBuffer->showText( 'Writing to a file.' );
$oMinify->write();

	/* Extract the doc block of the bootstrap class and write it to the beginning of the file. */
	
	/* Do the rest. */
	
	
/* Update the progress output. */		
$oProgressBuffer->showText( 'Done!' );

