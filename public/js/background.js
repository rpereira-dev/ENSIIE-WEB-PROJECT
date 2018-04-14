class Background {

	/* initialise openGL, appelé dans le constructeur */
	initGL() {
		/* le fragment shader */
		var FRAGMENT_SHADER_SRC = `
			#ifdef GL_ES
				precision highp float;
			#endif

			uniform float cursorX;
			uniform float cursorY;
			uniform float time;
			uniform sampler2D sampler;

			varying vec2 pass_uv;

			void main() {
				float off = cos(time * 0.1) * 0.005;
				gl_FragColor = 0.25 * (texture2D(sampler, pass_uv + vec2(off, off))
										+ texture2D(sampler, pass_uv + vec2(off, -off))
										+ texture2D(sampler, pass_uv + vec2(-off, off))
										+ texture2D(sampler, pass_uv + vec2(-off, -off))
										);
			}
		`;

		/* le vertex shader */
		var VERTEX_SHADER_SRC =`
			attribute vec2 position;
			attribute vec2 uv;

			varying vec2 pass_uv;

			void main(void) {
				gl_Position = vec4(position.x, position.y, 0.0, 1.0);
				pass_uv = uv;
			}
		`;

	    var err = gl.getError();
	    if (err != gl.NO_ERROR) {
	        console.log("GL error occured: a : " + err);
	    }

		gl.viewport(0, 0, canvas.width, canvas.height);
		gl.clearColor(1.0, 1.0, 1.0, 1.0);
		gl.clear(gl.COLOR_BUFFER_BIT);

		gl.enable(gl.DEPTH_TEST)

		gl.enable(gl.BLEND);
		gl.blendFunc(gl.SRC_ALPHA, gl.ONE);

		/* create shaders */
		this.vs = gl.createShader(gl.VERTEX_SHADER);
		this.fs = gl.createShader(gl.FRAGMENT_SHADER);
		gl.shaderSource(this.vs, VERTEX_SHADER_SRC);
		gl.shaderSource(this.fs, FRAGMENT_SHADER_SRC);
		gl.compileShader(this.vs);
		gl.compileShader(this.fs);
	    if (!gl.getShaderParameter(this.vs, gl.COMPILE_STATUS)) {
	        alert("vertex shader error : " + gl.getShaderInfoLog(this.vs));
	    }
	    if (!gl.getShaderParameter(this.fs, gl.COMPILE_STATUS)) {
	        alert("fragment shader error : " + gl.getShaderInfoLog(this.fs));
	    }


		/* create rendering program */
		this.program = gl.createProgram();
		gl.attachShader(this.program, this.vs);
		gl.attachShader(this.program, this.fs);
		gl.linkProgram(this.program);
		/* use the program */
		gl.useProgram(this.program);


	    /* create vbo */
	    this.vbo = gl.createBuffer();
	    gl.bindBuffer(gl.ARRAY_BUFFER, this.vbo);
	    var attrPosition	= gl.getAttribLocation(this.program, "position");
	    var attrUv			= gl.getAttribLocation(this.program, "uv");
	    var step	= 4 * Float32Array.BYTES_PER_ELEMENT;
	    var offset	= 0;

	    gl.vertexAttribPointer(attrPosition, 	2, gl.FLOAT, false,	step, offset);
	    gl.enableVertexAttribArray(attrPosition);
	    offset += 2 * Float32Array.BYTES_PER_ELEMENT;

	    gl.vertexAttribPointer(attrUv,			2, gl.FLOAT, false,	step, offset);
	    gl.enableVertexAttribArray(attrUv);
	    offset += 2 * Float32Array.BYTES_PER_ELEMENT;

	  	var vertices = [
	  		-1, -1, 0, 1,
	  		 1, -1, 1, 1,
	  		 1,  1, 1, 0,

	  		-1, -1, 0, 1,
	  		 1,  1, 1, 0,
	  		-1,  1, 0, 0
	  	];
	  	gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STATIC_DRAW);
	  	this.vertexCount = 6;

	    /* uniforms */
	   	this.u_cursorX = gl.getUniformLocation(this.program, "cursorX");
	   	this.u_cursorY = gl.getUniformLocation(this.program, "cursorY");
	   	this.u_time    = gl.getUniformLocation(this.program, "time");
	}

	initTextures() {
		function loadImage(url) {
			var tex = gl.createTexture();
			gl.bindTexture(gl.TEXTURE_2D, tex);

			// let's assume all images are not a power of 2
			gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
			gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
			gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);

			var textureInfo = {
				width: 1,   // we don't know the size until it loads
				height: 1,
				texture: tex,
			};
			var img = new Image();
			img.addEventListener('load', function() {
				textureInfo.width = img.width;
				textureInfo.height = img.height;

				gl.bindTexture(gl.TEXTURE_2D, textureInfo.texture);
				gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, img);
			});
			img.src = url;
			return (textureInfo);
		}
		this.lolbg = loadImage("./images/lolbg.png");

	   	/* bind texture */
	   	gl.bindTexture(gl.TEXTURE_2D, this.lolbg.texture);
	}


	//TODO : when to call it?
	deinitGL() {
		gl.deleteShader(this.fs);
		gl.deleteShader(this.vs);
		gl.deleteProgram(this.program);
		gl.deleteBuffer(this.vbo);
	}

	/* constructeur par défaut */
	constructor() {
		/* context du cavans sur lequel dessiné */
		this.ctx = canvas.getContext("2d");

		/* initialisation OpenGL */
		this.initGL();

		/* generation des points / triangles */
		this.initTextures();
	}

	/**
	 *	Met à jour le fond d'écran
	 *
	 *	@param dt : temps entre le dernier appel de cette fonction et maintenant
	 */
	 update(dt) {
	}

	/**
	 *	Met à jour le canvas sur lequel le fond est dessiné
	 */
	 draw() {
		/* clear screen */
		//gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

		/* uniforms */
		gl.uniform1f(this.u_cursorX, 2.0 * cursorX / canvas.width - 1.0);
		gl.uniform1f(this.u_cursorY, 2.0 * (1.0 - cursorY / canvas.height) - 1.0);
		var ms = new Date().getMilliseconds();
		if (ms > 500) {
			ms = 1000 - ms;
		}
		var t = ms / 500.0 * 3.1418 * 2.0;
		gl.uniform1f(this.u_time, t);

		/* draw */
		gl.drawArrays(gl.TRIANGLES, 0, this.vertexCount);

	    var err = gl.getError();
	    if (err != gl.NO_ERROR) {
	        console.log("GL error occured: " + err);
	    }
	}
}

/** appelé au chargement de la page */
function onPageLoaded() {
	initCanvas();
	initMouse();
	initLoop();
	loop();
}

/** initialisations */

function initCanvas() {
	canvas = document.getElementById("bgCanvasID");
	onResize();
	gl = canvas.getContext("experimental-webgl");

	/*canvas.style.webkitFilter = "blur(3px)";*/
}

function onResize() {
	canvas.width = window.innerWidth;
	canvas.height = window.innerHeight;
}

function initMouse() {
	onCursorMove(canvas.width / 2, canvas.height / 2);
	document.onmousemove = function(e) {
		onCursorMove(e.pageX, e.pageY);
	}
}

function onCursorMove(x, y) {
	cursorX = x;
	cursorY = y;
}

function initLoop() {
	now = Date.now();
	then = Date.now();
	fps = 60.0;
	interval = 1.0 / fps;
	timeElapsed = 0;
	background = new Background();
	window.onresize = onResize;
}

/** boucle de dessin */
async function loop() {
	requestAnimationFrame(loop);

	/* l'heure actuelle */
	var now = Date.now();
	/* l'heure du dernier dessin */
	var dt = (now - then) / 1000.0;
	/* on incremente le temps total */
	timeElapsed += dt;
	/* on met à jour, on dessine */
	background.update(dt);
	background.draw();
	then = now;

	/** on attends le temps du prochain dessin */
	await new Promise(resolve => setTimeout(resolve, interval));

}