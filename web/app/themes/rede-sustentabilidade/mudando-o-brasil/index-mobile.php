<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=0, maximum-scale=0">
		<style>
		@font-face {
			font-family: 'icomoon';
			src:url('/content/themes/rede-sustentabilidade/assets/fonts/icones/fonts/icomoon.eot');
			src:url('/content/themes/rede-sustentabilidade/assets/fonts/icones/fonts/icomoon.eot?#iefix') format('embedded-opentype'),
				url('/content/themes/rede-sustentabilidade/assets/fonts/icones/fonts/icomoon.woff') format('woff'),
				url('/content/themes/rede-sustentabilidade/assets/fonts/icones/fonts/icomoon.ttf') format('truetype'),
				url('/content/themes/rede-sustentabilidade/assets/fonts/icones/fonts/icomoon.svg#icomoon') format('svg');
			font-weight: normal;
			font-style: normal;
		}

		@font-face {
	    font-family: 'PT Sans';
	    src: url('/content/themes/rede-sustentabilidade/assets/fonts/PT-Sans-fontfacekit/ptsans_regular_macroman/PTS55F-webfont.eot');
	    src: url('/content/themes/rede-sustentabilidade/assets/fonts/PT-Sans-fontfacekit/ptsans_regular_macroman/PTS55F-webfont.eot?#iefix') format('embedded-opentype'),
	         url('/content/themes/rede-sustentabilidade/assets/fonts/PT-Sans-fontfacekit/ptsans_regular_macroman/PTS55F-webfont.woff') format('woff'),
	         url('/content/themes/rede-sustentabilidade/assets/fonts/PT-Sans-fontfacekit/ptsans_regular_macroman/PTS55F-webfont.ttf') format('truetype'),
	         url('/content/themes/rede-sustentabilidade/assets/fonts/PT-Sans-fontfacekit/ptsans_regular_macroman/PTS55F-webfont.svg#pt_sansregular') format('svg');
	    font-weight: normal;
	    font-style: normal;
		}

		[class^="icon-"], [class*=" icon-"] {
		    font-family: 'icomoon';
		    speak: none;
		    font-style: normal;
		    font-weight: normal;
		    font-variant: normal;
		    text-transform: none;
		    line-height: 1;

		    /* Better Font Rendering =========== */
		    -webkit-font-smoothing: antialiased;
		    -moz-osx-font-smoothing: grayscale;
		}
		.icon-warning:before {
		    content: "\e611";
		}

			body{
				background-color:#E3C492;
			}
			.container{
				height:60%;
				margin:20% 0;
				text-align: center;
			}

			.disclaimer{
				margin: 10% 0;
				color: #FFF;
				font-size:50px;
			}

			.partidos {
				display: block;
				width: 170px;
				height: 60px;
				background: url("/content/themes/rede-sustentabilidade/assets/images/partidos.png") no-repeat;
				margin: 0 auto;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
			.texto{
				font-family: 'PT Sans';
				margin:30% 10%;
				font-size:18px;
				color: #FFF;
			}
			a{
				font-size:18px;
				color: #FFF;
				font-weight:bold;
				text-decoration: none;
			}
		</style>
		<script>
			(function(){window.CM={set:function(c,a,b,d,e){c=escape(c)+"=";var f=escape;a="object"!==typeof a||!JSON.stringify?a:JSON.stringify(a);a=c+f(a);b&&(b.constructor===Number?a+=";max-age="+b:b.constructor===String?a+=";expires="+b:b.constructor===Date&&(a+=";expires="+b.toUTCString()));a+=";path="+(d?d:"/");e&&(a+=";domain="+e);document.cookie=a},setObject:function(c,a,b,d){for(var e in c)CM.set(e,c[e],expires,b,d)},get:function(c){return CM.getObject()[c]},getObject:function(){var c=document.cookie.split(/;\s?/i),a={},b,d;for(d in c)if(b=c[d].split("="),!(1>=b.length)){var e=a,f=unescape(b[0]),g;a:{b=unescape(b[1]);try{g=JSON.parse(b);break a}catch(h){}g=b}e[f]=g}return a},unset:function(c){document.cookie=c+"=; expires="+(new Date(0)).toUTCString()},clear:function(){var c=CM.getObject(),a;for(a in c)CM.unset(a)}}})();
			function setCookie(){
				var de = new Date();
				CM.set('rs-template', 'web', de.setDate( de.getDate() + 2 ) );
				window.location.reload();
			}
		</script>
	</head>
	<body>
		<div class="container">
			<div class="disclaimer">
				<i class="icon-warning"></i>
			</div>
			<div class="partidos"></div>
			<div class="texto">
				Ops! Essa página ainda não tem versão mobile.<br>
					<a href="#" onclick="setCookie()">Clique aqui para ver a versão web.</a>
			</div>
		</div>
	</body>
</html>
