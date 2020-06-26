<?php view::layout('themes/'.(config('style')?config('style'):'material').'/layout')?>

<?php view::begin('content');?>
  <link rel="stylesheet" href="https://qn.xieqifei.com/bootstrap.min.css">
  <link href="https://qn.xieqifei.com/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
  <link href="https://qn.xieqifei.com/main.css" rel="stylesheet" type="text/css"/>
  <body>
      <header class="main-head page-header">
        <h1>Aria2前端工具</h1>
        <span id="offline-cached"></span>
        <div id="global-info" class="pull-right">
          <div id="global-version"></div>
          <div id="global-speed"></div>
        </div>
      </header>

      <div class="clearfix hide" id="main-control">
        <div id="main-alert" class="hide">
          <div id="main-alert-inline" class="alert">
            <a href="#" id="btnClearAlert"  class="close">×</a>
            <span class="alert-msg">Loading</span>
          </div>
        </div>

        <div class="pull-left">
          <div class="btn-group" id="select-btn">
            <button id="select-all-btn" class="btn" rel="tooltip" title="Select All">
              <i class="select-box"></i>
            </button>
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#" id="btnSelectActive" >进行中</a></li>
              <li><a href="#" id="btnSelectWaiting">等待中</a></li>
              <li><a href="#" id="btnSelectPaused" >暂停中</a></li>
              <li><a href="#" id="btnSelectStopped" >已完成</a></li>
            </ul>
          </div>
        </div>

        <div class="pull-left" id="not-selected-grp">
          <div class="pull-left btn-group">
            <a class="btn" id="add-task-btn" data-toggle="modal" href="#add-task-modal" rel="tooltip" title="Add Task">
              <i class="icon-plus"></i> 添加
            </a>
          </div>
          <div class="pull-left btn-group" id="do-all-btn">
            <a href="#" id="btnStartAll" class="btn" id="unpause-all" rel="tooltip" title="Start All">
              <i class="icon-forward"></i>
            </a>
            <a href="#" id="btnPauseAll"  class="btn" id="pause-all" rel="tooltip" title="Pause All">
              <i class="icon-stop"></i>
            </a>
            <a href="#" id="btnRemoveFinished"  class="btn" id="pure-all" rel="tooltip" title="Remove Finished Tasks">
              <i class="icon-trash"></i>
            </a>
          </div>
        </div>

        <div class="pull-left hide" id="selected-grp">
          <div class="btn-group">
            <a href="#" id="btnUnPause" class="btn" rel="tooltip" title="Start">
              <i class="icon-play"></i>
            </a>
            <a href="#" id="btnPause"   class="btn" rel="tooltip" title="Pause">
              <i class="icon-pause"></i>
            </a>
            <a href="#" id="btnRemove"  class="btn" rel="tooltip" title="Remove">
              <i class="icon-remove"></i>
            </a>
          </div>
          <!--<button class="btn pull-left" id="info-btn" rel="tooltip" title="Task Info">-->
            <!--<i class="icon-info-sign"></i> Info-->
          <!--</button>-->
        </div>

        <div class="pull-right" id="other-grp">
          <div class="btn-group">
            <a href="#" class="btn" id="refresh-btn" rel="tooltip" title="Refresh">
              <i class="icon-refresh"></i> 刷新
            </a>
            <a class="btn" id="setting-btn" data-toggle="modal" href="#setting-modal" rel="tooltip" title="Settings">
              <i class="icon-wrench"></i>
            </a>
          </div>
        </div>
      </div>

      <section id="active-tasks">
      <div class="section-header">
        <i class="icon-chevron-down"></i><b>活动任务</b>
      </div>
      <ul class="tasks-table" id="active-tasks-table">
        <li>
          <div class="empty-tasks">
            <strong>无活动任务</strong>
          </div>
        </li>
      </ul>
      </section>

      <section id="other-tasks">
      <div class="section-header">
        <i class="icon-chevron-down"></i><b>其他任务</b>
      </div>
      <ul id="waiting-tasks-table" class="tasks-table">
        <li>
          <div class="empty-tasks">
            <strong>无任务</strong>
          </div>
        </li>
      </ul>
      <ul id="stopped-tasks-table" class="tasks-table"> </ul>
      </section>

    <ul id="task-contextmenu" class="dropdown-menu">
      <li class="task-restart"><a href="#" id="menuRestart" >重启</a></li>
      <li class="task-start"><a href="#" id="menuStart" >启动</a></li>
      <li class="task-pause"><a href="#" id="menuPause" >暂停</a></li>
      <li><a href="#" id="menuRemove" >移动</a></li>
      <li class="task-move divider"></li>
      <li class="task-move"><a href="#" id="menuMoveTop" >移至顶部</a></li>
      <li class="task-move"><a href="#" id="menuMoveUp" >向上移动</a></li>
      <li class="task-move"><a href="#" id="menuMoveDown" >向下移动</a></li>
      <li class="task-move"><a href="#" id="menuMoveEnd" >移至底部</a></li>
    </ul>

    <section class="modal hide fade" id="add-task-modal">
    <div class="modal-header">
      <button class="close" data-dismiss="modal">×</button>
      <h3>添加任务</h3>
    </div>
    <div class="modal-body">
      <div id="add-task-alert" class="alert alert-error hide">
        <a href="#" id="closeAlert"  class="close">×</a>
        <strong>Error:</strong> <span class="alert-msg"></span>
      </div>
      <form id="add-task-uri">
        <div class="input-append">
          <input type="text" name="uri" id="uri-input" class="input-clear" placeholder="HTTP, FTP or Magnet" /><span><a id="torrent-up-btn" class="btn">Upload Torrent<input type="file" id="torrent-up-input" /></a></span>
        </div>
        <textarea id="uri-textarea" rows=5 class="input-clear hide" placeholder="HTTP, FTP or Magnet"></textarea>
      </form>
      <div id="uri-more"><span class="or-and">&or;&or;&or;&or;&or;&or;</span><span class="or-and" style="display:none;">&and;&and;&and;&and;&and;&and;</span></div>
      <div id="add-task-option-wrap"></div>
    </div>
    <div class="modal-footer">
      <a href="#" id="add-task-submit" class="btn btn-primary">添加</a>
      <a href="#" id="add-task-clear" class="btn" data-dismiss="modal">取消</a>
    </div>
    </section>

    <section class="modal hide fade" id="setting-modal">
    <div class="modal-header">
      <button class="close" data-dismiss="modal">×</button>
      <h2>设置</h2>
    </div>
    <div class="modal-body">
      <form id="setting-form" class="form-horizontal">
        <fieldset>
          <div class="control-group rpc-path-group">
            <label class="control-label" for="rpc-path">JSON-RPC 路径</label>
            <div class="controls">
              <div class="input-append btn-group rpc-path-wrap">
                <input type="text" class="input-xlarge" id="rpc-path"><a class="add-on btn dropdown-toggle" href="#" disabled><b class="caret"></b></a>
              </div>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">自动刷新</label>
            <div class="controls">
              <label class="radio inline">
                <input type="radio" name="refresh_interval" value="1000"> 1s
              </label>
              <label class="radio inline">
                <input type="radio" name="refresh_interval" value="5000" checked> 5s
              </label>
              <label class="radio inline">
                <input type="radio" name="refresh_interval" value="10000"> 10s
              </label>
              <label class="radio inline">
                <input type="radio" name="refresh_interval" value="60000"> 1min
              </label>
              <label class="radio inline">
                <input type="radio" name="refresh_interval" value="0"> off 
              </label>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">完成时提醒</label>
            <div class="controls">
              <label class="radio inline">
                <input type="radio" name="finish_notification" value="1" checked> 开启提醒
              </label>
              <label class="radio inline">
                <input type="radio" name="finish_notification" value="0"> 关闭提醒
              </label>
            </div>
          </div>
        </fieldset>
      </form>
      <div id="aria2-gsetting">
      </div>
    </div>
    <div class="modal-footer">
      <div id="copyright">© Copyright <a href="https://github.com/binux/yaaw">Binux</a></div>
      <a href="#" id="saveSettings"  class="btn btn-success">保存</a>
      <a href="#" class="btn" data-dismiss="modal">取消</a>
    </div>
    </section>
    
    <script id="global-speed-tpl" type="text/mustache-template">
      <i class="icon-download"></i> <span>{{#_v.format_size}}{{downloadSpeed}}{{/_v.format_size}}</span>/s
        / 
      <i class="icon-upload"></i>  <span>{{#_v.format_size}}{{uploadSpeed}}{{/_v.format_size}}</span>/s
    </script>

    <script id="active-task-tpl" type="text/mustache-template">
      {{#tasks}}
      <li class="task" id="task-gid-{{gid}}" data-status="{{status}}" data-gid="{{gid}}">
        <div class="left-area">
          <div class="task-name">
            <i class="select-box"></i>
            <span title="{{title}}">{{title}}</span>
          </div>
          <div class="task-info">
            <span class="task-status" rel="tooltip" title="{{status}} {{#_v.error_msg}}{{errorCode}}{{/_v.error_msg}}"><i class="{{#_v.status_icon}}{{status}}{{/_v.status_icon}}"></i></span>
            <span>{{#_v.format_size}}{{completedLength}}{{/_v.format_size}} / {{#_v.format_size}}{{totalLength}}{{/_v.format_size}}</span>
            {{#uploadLength}}<span>(uploaded {{#_v.format_size}}{{uploadLength}}{{/_v.format_size}})</span>{{/uploadLength}}
            {{#eta}}<span>ETA: {{#_v.format_time}}{{eta}}{{/_v.format_time}}</span>{{/eta}}
          </div>
        </div>
        <div class="right-area">
          <div class="progress {{progressStatus}}">
            <div class="bar" style="width: {{progress}}%">{{progress}}%</div>
          </div>
          <div class="progress-info">
            {{#downloadSpeed}}<span class="download-speed"><i class="icon-download"></i> {{#_v.format_size}}{{downloadSpeed}}{{/_v.format_size}}/s</span>{{/downloadSpeed}}
            {{#uploadSpeed}}<span class="upload-speed"><i class="icon-upload"></i> {{#_v.format_size}}{{uploadSpeed}}{{/_v.format_size}}/s</span>{{/uploadSpeed}}
            {{#connections}}<span class="seeders"><i class="icon-signal" rel="tooltip" title="Connections"></i> {{connections}}</span>{{/connections}}
            {{#numSeeders}}<span class="seeders"><i class="icon-magnet" rel="tooltip" title="Seeders"></i> {{numSeeders}}</span>{{/numSeeders}}
          </div>
        </div>
      </li>
      {{/tasks}}
      {{^tasks}}
      <li>
        <div class="empty-tasks">
          <strong>无活动任务</strong>
        </div>
      </li>
      {{/tasks}}
    </script>
    
    <script id="other-task-tpl" type="text/mustache-template">
      {{#tasks}}
      <li class="task" id="task-gid-{{gid}}" data-status="{{status}}" data-gid="{{gid}}" data-infohash="{{infoHash}}">
        <div class="left-area">
          <div class="task-name">
            <i class="select-box"></i>
            <span title="{{title}}">{{title}}</span>
          </div>
        </div>
        <div class="right-area">
          <div class="task-info pull-left">
            <span class="task-status" rel="tooltip" title="{{status}} {{#_v.error_msg}}{{errorCode}}{{/_v.error_msg}}"><i class="{{#_v.status_icon}}{{status}}{{/_v.status_icon}}"></i></span>
            <span>{{#_v.format_size}}{{totalLength}}{{/_v.format_size}}</span>
            {{#uploadLength}}<span>(up {{#_v.format_size}}{{uploadLength}}{{/_v.format_size}})</span>{{/uploadLength}}
          </div>
          <div class="pull-right">
            <div class="progress {{progressStatus}}">
              <div class="bar" style="width: {{progress}}%">{{progress}}%</div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </li>
      {{/tasks}}
    </script>

    <script id="info-box-tpl" type="text/mustache-template">
      <div class="info-box" data-gid="{{gid}}">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#ib-status" data-toggle="tab">Status</a></li>
            <li><a href="#ib-files" data-toggle="tab">Files</a></li>
            <li><a id="ib-options-a" href="#ib-options" data-toggle="tab">Options</a></li>
            <li><a id="ib-peers-a" class="hide" style="display:none;" href="#ib-peers" data-toggle="tab">Peers</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="ib-status"> </div>
            <div class="tab-pane" id="ib-files">
              <div id="ib-file-btn">
                <button id="ib-file-save" class="btn btn-primary">Save</button>
              </div>
              <div class="file-list">
              </div>
            </div>
            <div class="tab-pane" id="ib-options"> </div>
            <div class="tab-pane" id="ib-peers"> </div>
          </div>
        </div>
      </div>
    </script>      

    <script id="ib-status-tpl" type="text/mustache-template">
      <ul>
        {{#uris}}<li><strong>Url: </strong><a target=_blank href="{{.}}">{{.}}</a>{{/uris}}
        {{#infoHash}}<li><strong>Infohash: </strong><a target=_blank href="magnet:?xt=urn:btih:{{infoHash}}">{{infoHash}}</a></li>{{/infoHash}}
        <li><strong>Size: </strong>{{#_v.format_size}}{{totalLength}}{{/_v.format_size}} ({{numPieces}} @ {{#_v.format_size}}{{pieceLength}}{{/_v.format_size}})</li>
        <li><strong>Status: </strong>{{status}} {{error_msg}}</li>
        <li><strong>Dir: </strong>{{dir}}</li>
        {{#bittorrent}}
          {{#creationDate}}<li>Torrent Created At {{creationDate}}</li>{{/creationDate}}
          {{#comment}}<li><strong>Comment: </strong>{{comment}}</li>{{/comment}}
        {{/bittorrent}}
        <li class="bitfield"><strong>Bitfield: </strong>{{#_v.bitfield}}{{bitfield}}{{/_v.bitfield}}</li>
      </ul>
    </script>

    <script id="file-tpl" type="text/mustache-template">
        <li>
          <i class="select-box{{#selected}} icon-ok{{/selected}}" data-index="{{index}}"></i>
          <span class="ib-file-title">{{relative_title}}</span>
          <span class="ib-file-size"> {{#_v.format_size}}{{completedLength}}{{/_v.format_size}} / {{#_v.format_size}}{{length}}{{/_v.format_size}}</span>
        </li>
    </script>

    <script id="ib-options-tpl" type="text/mustache-template">
      <form id="ib-options-form" class="form-horizontal" onsubmit="false">
      <ul>
        <li id="ib-options-btn">
          <button id="ib-options-save" class="btn btn-primary">Save</button>
        </li>
        <li><span>Download Limit:</span><input name="max-download-limit" class="active-allowed" value="{{max-download-limit}}" /></li>
        <li><span>Upload Limit:</span><input name="max-upload-limit" class="active-allowed" value="{{max-upload-limit}}" /></li>
        <li><span>Split:</span><input name="split" value="{{split}}" /></li>
        <li><span>Conn per Serv:</span><input name="max-connection-per-server" value="{{max-connection-per-server}}" /></li>
        <li><span>Split Size:</span><input name="min-split-size" value="{{min-split-size}}" /></li>
      </form>
    </script>

    <script id="ib-peers-tpl" type="text/mustache-template">
      {{#.}}
      <li><span class="ip_port">{{ip}}:{{port}} - <span class="peerid">{{#_v.format_peerid}}{{peerId}}{{/_v.format_peerid}}</span></span> <b>{{#_v.bitfield_to_percent}}{{bitfield}}{{/_v.bitfield_to_percent}}%</b> <i class="icon-download"></i>{{#_v.format_size}}{{downloadSpeed}}{{/_v.format_size}}/s <i class="icon-upload"></i>{{#_v.format_size}}{{uploadSpeed}}{{/_v.format_size}}/s</li>
      {{/.}}
    </script>

    <script id="other-task-empty" type="text/mustache-template">
      <li>
        <div class="empty-tasks">
          <strong>无任务</strong>
        </div>
      </li>
    </script>

    <script id="add-task-option-tpl" type="text/mustache-template">
      <hr />
      <form id="add-task-option" class="form-horizontal" onsubmit="$('#add-task-uri').submit();return false">
	  <input type="submit" style="position:fixed;top:0;visibility:hidden"/>
        <div class="control-group">
          <label class="control-label" for="ati-out">File Name</label>
          <div class="controls">
            <input id="ati-out" class="input-xlarge input-clear" name="out" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="ati-dir">Dir</label>
          <div class="controls">
            <input id="ati-dir" class="input-xlarge" name="dir" />
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="control-group half">
          <div class="controls">
            <label class="checkbox">
              <input type="checkbox" name="pause" class="input-save" {{#pause}}checked{{/pause}} />
              Pause When Added
            </label>
          </div>
        </div>
        <div class="control-group half">
          <div class="controls">
            <label class="checkbox">
              <input type="checkbox" name="parameterized-uri" class="input-save" {{#parameterized-uri}}checked{{/parameterized-uri}} />
              Parameterized URI
            </label>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="control-group half">
          <label class="control-label" for="ati-split">Split</label>
          <div class="controls">
            <input id="ati-split" class="input-small input-save" name="split" value="{{split}}" />
          </div>
        </div>
        <div class="control-group half">
          <label class="control-label" for="ati-cps">Conn/Serv</label>
          <div class="controls">
            <input id="ati-cps" class="input-small input-save" name="max-connection-per-server" value="{{max-connection-per-server}}" />
          </div>
        </div>
        <div class="control-group half">
          <label class="control-label" for="ati-sr">Seed Ratio</label>
          <div class="controls">
            <input id="ati-sr" class="input-small input-save" name="seed-ratio" value="{{seed-ratio}}" />
          </div>
        </div>
        <div class="control-group half">
          <label class="control-label" for="ati-st">Seed Time</label>
          <div class="controls">
            <input id="ati-st" class="input-small input-save" name="seed-time" value="{{seed-time}}" />
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="control-group">
          <label class="control-label" for="ati-header">Header</label>
          <div class="controls">
            <textarea id="ati-header" class="input-xlarge input-save" name="header" warp="off">{{header}}</textarea>
          </div>
        </div>
      </form>
    </script>

    <script id="aria2-global-setting-tpl" type="text/mustache-template">
      <hr />
      <form id="aria2-gs-form" class="form-horizontal" onsubmit="false">
        <div class="control-group half">
          <label class="control-label" for="gsi-dl">Download Limit</label>
          <div class="controls">
            <input id="gsi-dl" name="max-overall-download-limit" class="input-small" value="{{max-overall-download-limit}}" />
          </div>
        </div>
        <div class="control-group half">
          <label class="control-label" for="gsi-ul">Upload Limit</label>
          <div class="controls">
            <input id="gsi-ul" name="max-overall-upload-limit" class="input-small" value="{{max-overall-upload-limit}}" />
          </div>
        </div>
        <div class="control-group half">
          <label class="control-label" for="gsi-cd">Concurrent Downs</label>
          <div class="controls">
            <input id="gsi-cd" name="max-concurrent-downloads" class="input-small" value="{{max-concurrent-downloads}}" />
          </div>
        </div>
        <div class="control-group half">
          <label class="control-label" for="gsi-mss">Min Split Size</label>
          <div class="controls">
            <input id="gsi-mss" name="min-split-size" class="input-small" value="{{#_v.format_size_0}}{{min-split-size}}{{/_v.format_size_0}}" />
          </div>
        </div>
        <div class="clearfix"></div>

        <div class="control-group">
          <label class="control-label" for="gsi-ua">User Agent</label>
          <div class="controls">
            <input id="gsi-ua" name="user-agent" class="input-xlarge" value="{{user-agent}}" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="gsi-dir">Base Dir</label>
          <div class="controls">
            <input id="gsi-dir" name="dir" class="input-xlarge" value="{{dir}}" disabled />
          </div>
        </div>
      </form>
    </script>

   <script src="https://qn.xieqifei.com/js/jquery-1.7.2.min.js"></script>
    <script src="https://qn.xieqifei.com/js/bootstrap.min.js"></script>
    <script src="https://qn.xieqifei.com/js/jquery.jsonrpc.js"></script>
    <script src="https://qn.xieqifei.com/js/jquery.Storage.js"></script>
    <script src="https://qn.xieqifei.com/js/jquery.base64.min.js"></script>
    <script src="https://qn.xieqifei.com/js/mustache.js"></script>
    <script src="https://qn.xieqifei.com/js/peerid.js"></script>
    <script src="https://qn.xieqifei.com/js/aria2.js"></script>
    <script src="https://qn.xieqifei.com/js/yaaw-1.1.js"></script>
  </body>
<?php view::end('content');?>
