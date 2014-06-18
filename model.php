<?php
	function editor_require(){
		?>
		<script type="text/javascript" charset="utf-8">
		    window.UEDITOR_HOME_URL = "/forum/ueditor/";  //UEDITOR_HOME_URL、config、all这三个顺序不能改变
		</script>
		<script type="text/javascript" src="./ueditor/ueditor.config.js"></script>
		<script type="text/javascript" src="./ueditor/ueditor.all.js"></script>
		<?php
	}
	function editor_display(){
		?>
		<script type="text/javascript" src="./ueditor/ueditor.parse.js"></script>
		<script type="text/javascript">
	    	function doUParse(){
	       		uParse('.content',{
		            'highlightJsUrl':'./ueditor/third-party/SyntaxHighlighter/shCore.js',
		            'highlightCssUrl':'./ueditor/third-party/SyntaxHighlighter/shCoreDefault.css'
		        });
		    }
		</script>
	    <script type="text/javascript">
		    doUParse();
	    </script>
		<?php
	}
?>