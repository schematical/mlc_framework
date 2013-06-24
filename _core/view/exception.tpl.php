<h1>
    <?php echo $_E->getMessage(); ?>
</h1>

<table>
    <tr>
        <th style='width:400Px;'>Call</th>

        <th>Line</th>
        <th>File</th>

    </tr>
    <?php  foreach($_E->getTrace() as $intIndex => $arrTraceData){
        if($arrTraceData["function"] == 'mlc_error_handler'){
            if(array_key_exists("file", $arrTraceData)){
                $arrLines = explode("\n",file_get_contents($arrTraceData["file"]));
                $arrTraceData["function"] = $arrLines[$arrTraceData["line"] - 1];
                $arrTraceData["args"] = null;
            }else{
                $arrTraceData["file"] = '??';
                $arrTraceData["line"] = '??';
            }
        }
        ?>
        <tr style='margin: 10Px; border: thin black solid;'>
            <td>
                <?php echo (array_key_exists("class", $arrTraceData)?$arrTraceData["class"]:''); ?>
                <?php echo (array_key_exists("type", $arrTraceData)?$arrTraceData["type"]:''); ?>
                <?php echo $arrTraceData["function"]; ?><?php
                if(
                    (array_key_exists("args", $arrTraceData)) &&
                    (!is_null($arrTraceData["args"]))
                ){
                    echo '[' . count($arrTraceData["args"]) . ']';
                    echo '(';

                    $arrNewArgs = array();
                    foreach($arrTraceData["args"] as $intIndex => $mixArg){
                        if(is_string($mixArg)){
                            $arrNewArgs[$intIndex] = 'String ' . htmlentities($mixArg);
                        }elseif(is_numeric($mixArg)){
                            $arrNewArgs[$intIndex] = 'Number ' . $mixArg;
                        }elseif(is_object($mixArg)){
                            $arrNewArgs[$intIndex] = get_class($mixArg);
                        }elseif(is_array($mixArg)){
                            $arrNewArgs[$intIndex] = 'Array(' . count($mixArg) . ')';
                        }elseif(is_null($mixArg)){
                            $arrNewArgs[$intIndex] = 'NULL';
                        }elseif(is_bool($mixArg)){
                            $arrNewArgs[$intIndex] = 'bool(' . ($mixArg?'true':'false') . ')';
                        }else{

                            $arrNewArgs[$intIndex] = 'Unknown(' . $mixArg . ')';
                        }
                    }
                    echo implode(', ', $arrNewArgs);
                    echo ');';
                }
                ?>
            </td>
            <td>
                <?php
                    if(array_key_exists("line", $arrTraceData)){
                        echo $arrTraceData["line"];
                    }
                ?>
            </td>
            <td>
                <?php
                    if(array_key_exists("line", $arrTraceData)){
                       echo $arrTraceData["file"];
                    }
                ?>
            </td>

        </tr>
    <?php } ?>
</table>