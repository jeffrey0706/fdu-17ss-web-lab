<html>
<head>
<title>LRC 歌词编辑器</title>
<style>
    nav ul {
        position: fixed;
        z-index: 99;
        right: 5%;
        border: 1px solid darkgray;
        border-radius: 5px;
        list-style:none;
        padding: 0;
    }

    .tab {
        padding: 1em;
        display: block;
    }

    .tab:hover {
        cursor: pointer;
        background-color: lightgray !important;
    }

    td {
        padding:0.2em;
    }

    textarea[name="edit_lyric"] {
        width: 100%;
        height: 50em;
    }

    input[type="button"] {
        width: 100%;
        height: 100%;
    }

    input[type="submit"] {
        width: 100%;
        height: 100%;
    }

    #td_submit {
        text-align: center;
    }

    select {
        display: block;
    }

    #lyric {
        width: 35%;
        height: 60%;
        border: 0;
        resize: none;
        font-size: large;
        line-height: 2em;
        text-align: center;
    }
</style>
</head>
<body>
    <nav><ul>
        <li id="d_edit" class="tab">Edit Lyric</li>
        <li id="d_show" class="tab">Show Lyric</li>
    </ul></nav>

<!--歌词编辑部分-->
<section id="s_edit" class="content">
<form id="f_upload" enctype="multipart/form-data" onsubmit="return check();" method="post" action="upload-Lab11.php">
    <p>请上传音乐文件</p>

    <!--TODO: 在这里补充 html 元素，使 file_upload 上传后若为音乐文件，则可以直接播放-->
    <audio src="" autoplay="" controls="" id="audio" style="width:450px;"></audio><br/>

    <input type="file" name="file_upload" accept="audio/mpeg" onchange="playMusic();">
    <table>
        <tr><td>Title: <input type="text"></td><td>Artist: <input type="text"></td><td><input type="text" id="inputName" name="inputName" style="visibility:hidden"></td></tr>
        <tr><td colspan="2"><textarea name="edit_lyric" id="edit_lyric"></textarea></td></tr>
        <tr><td><input type="button" value="插入时间标签" onclick="insert()"></td><td><input type="button" value="替换时间标签"></td></tr>
        <tr><td colspan="2" id="td_submit"><input type="submit" value="Submit"></td></tr>   
    </table>
</form>
</section>

<!--歌词展示部分-->
<section id="s_show" class="content">
    <select id="song" onchange="song_lyric()">
    <!--TODO: 在这里补充 html 元素，使点开 #d_show 之后这里实时加载服务器中已有的歌名-->
        <option value="0">Select One</option>
        <?php
        $fso = opendir('upload/');
        echo '<script> var lyrs = new Array(); </script>';
        $num = 0;
        while ($file = readdir($fso)) {
            if (stripos($file, ".lrc") !== false) {
                $temp = fopen("upload/" . $file, "r");
                $text = fread($temp, filesize("upload/" . $file));
                $text = str_replace(PHP_EOL, "", $text);
                fclose($temp);
                $name = str_replace(".lrc", "", $file);
                echo '<script> lyrs["' . $name . '"] = "' . $text . '"; </script>';
            }
            else if (stripos($file, ".mp3") !== false) {
                $name = str_replace(".mp3", "", $file);
                echo '<option value="' . $name . '">'. $name . '</option>';
            }
        }
        closedir($fso);
        ?>
    
    </select>

    <div id="lyric" style="height:400px; overflow-y:scroll; overflow-x:visible;">
    </div><br/>
    
    <!--TODO: 在这里补充 html 元素，使选择了歌曲之后这里展示歌曲进度条，并且支持上下首切换-->
    <audio src="" controls="" autoplay="" id="showAudio" style="width:450px; visibility:hidden;"></audio><br/>

</section>
</body>
<script>

//VARIABLES
var fileName;
var regex = new RegExp("\\[\\d{2}:\\d{2}:\\d{2}.\\d{2}\\]", "g");
var lrcLine = new Array();

// 界面部分
document.getElementById("d_edit").onclick = function () {click_tab("edit");};
document.getElementById("d_show").onclick = function () {click_tab("show");};

document.getElementById("d_show").click();

function click_tab(tag) {
    for (let i = 0; i < document.getElementsByClassName("tab").length; i++) document.getElementsByClassName("tab")[i].style.backgroundColor = "transparent";
    for (let i = 0; i < document.getElementsByClassName("content").length; i++) document.getElementsByClassName("content")[i].style.display = "none";

    document.getElementById("s_" + tag).style.display = "block";
    document.getElementById("d_" + tag).style.backgroundColor = "darkgray";
} 

// Edit 部分
var edit_lyric_pos = 0;
document.getElementById("edit_lyric").onmouseleave = function () {
    edit_lyric_pos = document.getElementById("edit_lyric").selectionStart;
};

// 获取所在行的初始位置。
function get_target_pos(n_pos) {
    if (n_pos === undefined) n_pos = edit_lyric_pos;
    let value = document.getElementById("edit_lyric").value; 
    let pos = 0;
    for (let i = n_pos; i >= 0; i--) {
        if (value.charAt(i) === '\n') {
            pos = i + 1;
            break;
        }
    }
    return pos;
}

// 选中所在行。
function get_target_line(n_pos) {
    let value = document.getElementById("edit_lyric").value; 
    let f_pos = get_target_pos(n_pos);
    let l_pos = 0;

    for (let i = f_pos;; i++) {
        if (value.charAt(i) === '\n') {
            l_pos = i + 1;
            break;
        }
    }
    return [f_pos, l_pos];
}

//PLAY THE MUSIC
function playMusic() {
    var reader = new FileReader();
    reader.onload = function (event) {
            document.getElementById("audio").src = event.target.result;
    };
    if(document.getElementsByName("file_upload")[0].files[0] != undefined) {
        reader.readAsDataURL(document.getElementsByName("file_upload")[0].files[0]);
        fileName = document.getElementsByName("file_upload")[0].files[0].name;
        document.getElementById("inputName").value = fileName;
    }
}

//INSERT TIME TAG
function insert() {
    let time = parseInt(document.getElementById("audio").currentTime*100);
    let ms = time%100;
    time = parseInt(time/100);
    let ss = time%60;
    let mm = ((time-ss)/60)%60;
    let hh = (((time-ss)/60)-mm)/60;
    if(ms < 10)
      ms = "0" + ms; 
    if(ss < 10)
      ss = "0" + ss; 
    if(mm < 10)
      mm = "0" + mm; 
    if(ss < 10)
      hh = "0" + hh; 
    document.getElementById("edit_lyric").value += ("[" + hh + ":" + mm + ":" + ss + "." + ms + "]");
}

//CHECK FORM
function check() {
    if(fileName == undefined) {
        alert("You Need To Choose A File First!");
        return false;
    }
}

//CHANGE TEXTAREA AND AUDIO
function song_lyric() {
    let song = document.getElementById("song").value;
    if(song == 0) {
        document.getElementById("lyric").innerHTML = "";
        document.getElementById("showAudio").src = "";
        document.getElementById("showAudio").style.visibility = "hidden";
    }
    else {
        document.getElementById("lyric").innerHTML = timeSplit(lyrs[song]);
        document.getElementById("showAudio").src = "upload/" + song + ".mp3";
        document.getElementById("showAudio").addEventListener("timeupdate", function() {
            let time = document.getElementById("showAudio").currentTime;
            let line = lrcLine.length;
            for(let j=0; j<line-1; j++) {
                 if(lrcLine[j][0] < time && lrcLine[j+1][0] > time) {
                     if(j !== 0)
                         lrcLine[j-1][1] = lrcLine[j-1][1].replace("<b>", "").replace("</b>", "");
                     lrcLine[j][1] = "<b>" + lrcLine[j][1] + "</b>";
                     let total = "";
                     for(x in lrcLine)
                         total += lrcLine[x][1];
                     document.getElementById("lyric").innerHTML = total;
                     break;
                 }
             }
             let last = true;
             for(let j=0; j<line; j++) {
                 if(lrcLine[j][0] < time)
                     continue;
                 last = false;
             }
             if(last) {
                 lrcLine[line-2][1] = lrcLine[line-2][1].replace("<b>", "").replace("</b>", "");
                 lrcLine[line-1][1] = "<b>" + lrcLine[line-1][1] + "</b>";
                 let total = "";
                 for(x in lrcLine)
                     total += lrcLine[x][1];
                 document.getElementById("lyric").innerHTML = total;
             }
        });
        document.getElementById("showAudio").style.visibility = "visible";
    }
}

//USE REGEX TO SPLIT LYRIC
function timeSplit(str) {
    lrcLine = new Array();
    let total = "";
    let tag = str.match(regex);
    let num = tag.length;
    str = str.replace(regex, "\n").trim().split("\n");
    for(let j=0; j<num; j++) {
        let regexTemp = new RegExp("\\d{2}", "g");
        let temp = "<span id='span" + j + "'>" + str[j] + "</span><br/>";
        let time = tag[j].match(regexTemp);
        time = parseInt(time[0])*3600 + parseInt(time[1])*60 + parseInt(time[2]) + parseInt(time[3])*0.01;
        lrcLine[j] = [time, temp];
    }
    for(x in lrcLine)
        total += lrcLine[x][1];
    return total;
}


/* HINT: 
 * 已经帮你写好了寻找每行开头的位置，可以使用 get_target_pos()
 * 来获取第一个位置，从而插入相应的歌词时间。
 * 在 textarea 中，可以通过这个 DOM 节点的 selectionStart 和
 * selectionEnd 获取相对应的位置。
 *
 * TODO: 请实现你的歌词时间标签插入效果。
 */

/* TODO: 请实现你的上传功能，需包含一个音乐文件和你写好的歌词文本。
 */

/* HINT: 
 * 实现歌词和时间的匹配的时候推荐使用 Map class，ES6 自带。
 * 在 Map 中，key 的值必须是字符串，但是可以通过字符串直接比较。
 * 每一行行高可粗略估计为 40，根据电脑差异或许会有不同。
 * 当前歌词请以粗体显示。
 * 从第八行开始，当歌曲转至下一行的时候，需要调整滚动条，使得当前歌
 * 词保持在正中。
 *
 * TODO: 请实现你的歌词滚动效果。
 */

</script>
</html>
