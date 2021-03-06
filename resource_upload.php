<?php
require_once __DIR__ . '/conf/AppConfig.class.php';
require_once __DIR__ . '/src/Startup.class.php';
require_once __DIR__.'/startup.php';

if(empty($_SESSION['admin_id']) && empty($_SESSION['supper_admin_id'])){

  header('Location: ./admin/index.php');
}

$error = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  // Check to see if we have a file to be uploaded
  set_time_limit(0);
  try{

    list($hash, $name, $extension, $size) =
    MediaUtils::handleMediaFileUpload('mediafile');

    // if we get this far we need to store the records
    $q =
    sprintf(
      'INSERT INTO resource_media_files '.
      '(fileHash,fileName,fileType,fileSize) '.
      'VALUES("%s", "%s", "%s", "%s")'
      , $hash
      , $name
      , $extension
      , $size);

    executeQuery($q);
    // if we are done we need to redirect to the recource lists
    $uri = 'resource_lists.php';
    header("Location:{$uri}");
    exit;
  }catch(Exception $ex){
    $error = $ex->getMessage();
  }
}
// pull resources from the
$title = 'Media Resource Upload';
include_once 'header.php';
?>
    <div class="wrappers" id="wrappers">
        <div id="container">
          <table border="0" style="margin-top:80px;margin-left:auto;margin-right:auto;width:920px;border-bottom:1px solid #d9d8d7;">
            <tr>
              <td style="width:60%;">
                <h2 style="font-size:11;padding:3px;margin:3px;">Upload Resource</h2>
              </td>
              <td align="right">
                <a href="resource_lists.php"><b>View Resources</b></a> &nbsp;&nbsp; - &nbsp;&nbsp;
                <a href="resources.php"><b>View Panel</b></a>
              </td>
            </tr>
            <tr>
              <td style="padding:10px;" colspan="2">
                <hr/>
                <div style="clear:both;?>"></div>
                <form method="post" enctype="multipart/form-data">
                  <table cellpadding="10"
                         cellspacing="10"
                         style="margin-left:auto;margin-right:auto;width:50%;" border="0">
                    <?php if($error !== null):?>
                      <tr>
                        <td align="center">
                          <div class="alert alert-danger"><?php echo $error;?></div>
                        </td>
                      </tr>
                    <?php endif;?>
                    <tr>
                      <td align="center">
                        <input type="file" name="mediafile" id="mediafile"/>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        <div class="alert alert-info">Select a media file to upload</div>
                      </td>
                    </tr>
                    <tr>
                      <td align="center"><button name="fileup" class="btn btn-primary">Start Uploading</button></td>
                    </tr>
                  </table>
                </form>
                <div style="clear:both;?>"></div>
              </td>
            </tr>
          </table>
        </div>
      </div>
</body>
</html>
