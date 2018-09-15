/*!
 * jQuery ClassyGradient
 * www.class.pm
 *
 * Written by Marius Stanciu - Sergiu <marius@class.pm>
 * Licensed under the MIT license www.class.pm/LICENSE-MIT
 * Version 1.1.0
 *
 */

(function($) {
    $.ClassyGradient = function(element, options) {
        var defaults = {
            gradient: '0% #02CDE8, 100% #000000',
            width: 300,
            height: 18,
            point: 8,
            orientation: 'vertical',
            target: null,
            onChange: function() {

            },
            onInit: function() {

            }
        };
        var $element = $(element), _container, _canvas, $pointsContainer, $pointsInfos, $pointsInfosContent, $pointColor, $pointPosition, $btnPointDelete, _context, _selPoint;
        var points = new Array();
        this.settings = {};
        this.__constructor = function() {
            this.settings = $.extend({}, defaults, options);
            this.update();
            this.settings.onInit();
            return this;
        };
        this.update = function() {
            this._setupPoints();
            this._setup();
            this._render();
        };
        this.getCSS = function() {
            var out = '', svgX = '0%', svgY = '100%', webkitDir = 'left bottom', defDir = 'top';
            if (this.settings.orientation === 'horizontal') {
                svgX = '100%';
                svgY = '0%';
                webkitDir = 'right top';
                defDir = 'left';
            }

			defDir = this.settings.orientation; // hack by amit

            var svg = '<svg xmlns="http://www.w3.org/2000/svg">' + '<defs>' + '<linearGradient id="gradient" x1="0%" y1="0%" x2="' + svgX + '" y2="' + svgY + '">';
            var webkitCss = '-webkit-gradient(linear, left top, ' + webkitDir;
            var defCss = '';
            $.each(points, function(i, el) {
                webkitCss += ', color-stop(' + el[0] + ', ' + el[1] + ')';
                defCss += ',' + el[1] + ' ' + el[0] + '';
                svg += '<stop offset="' + el[0] + '" style="stop-color:' + el[1] + ';" />';
            });
            webkitCss += ')';
            defCss = defCss.substr(1);
            svg += '</linearGradient>' + '</defs>' + '<rect fill="url(#gradient)" height="100%" width="100%" />' + '</svg>';
            svg = this._base64(svg);
            out += 'background: url(data:image/svg+xml;base64,' + svg + ');' + '\n';
            out += 'background: ' + webkitCss + ';\n';
            out += 'background: ' + '-moz-linear-gradient(' + defDir + ',' + defCss + ');' + '\n';
            out += 'background: ' + '-webkit-linear-gradient(' + defDir + ',' + defCss + ');' + '\n';
            out += 'background: ' + '-o-linear-gradient(' + defDir + ',' + defCss + ');' + '\n';
            out += 'background: ' + '-ms-linear-gradient(' + defDir + ',' + defCss + ');' + '\n';
            out += 'background: ' + 'linear-gradient(' + defDir + ',' + defCss + ');';
            return out;
        };
        this.getArray = function() {
            return points;
        };
        this.getString = function() {
            var out = '';
            $.each(points, function(i, el) {
                out += el[0] + ' ' + el[1] + ',';
            });
            out = out.substr(0, out.length - 1);
            return out;
        };
        this.setOrientation = function(orientation) {
            this.settings.orientation = orientation;
            this._renderToTarget();
        };
        this._setupPoints = function() {
            points = new Array();
            if ($.isArray(this.settings.gradient)) {
                points = this.settings.gradient;
            }
            else {
                points = this._getGradientFromString(this.settings.gradient);
            }
        };
        this._setup = function() {
            var self = this;
            $element.empty();
            _container = $('<div class="ClassyGradient"></div>');
            _canvas = $('<canvas class="canvas" width="' + this.settings.width + '" height="' + this.settings.height + '"></canvas>');
            _container.append(_canvas);
            _context = _canvas.get(0).getContext('2d');
            $pointsContainer = $('<div class="points"></div>');
            $pointsContainer.css('width', (this.settings.width) + Math.round(this.settings.point / 2 + 1) + 'px');
            _container.append($pointsContainer);
            $pointsInfos = $('<div class="info"></div>');
            $pointsInfos.append('<div class="arrow"></div>');
            _container.append($pointsInfos);
            $pointsInfosContent = $('<div class="content"></div>');
            $pointsInfos.append($pointsInfosContent);
            $element.hover(function() {
                $element.addClass('hover');
            }, function() {
                $element.removeClass('hover');
            });
            $pointColor = $('<div class="point-color"><div style="background-color: #00ff00"></div></div>');
            $pointPosition = $('<span class="point-position">%</span>');
            $btnPointDelete = $('<a href="#" class="delete"></a>');
            $pointsInfosContent.append($pointColor, $pointPosition, $btnPointDelete);
            $element.append(_container);
            $pointColor.ColorPicker({
                color: '#00ff00',
                onSubmit: function(hsb, hex, rgb) {
                    $element.find('.point-color div').css('backgroundColor', '#' + hex);
                    _selPoint.css('backgroundColor', '#' + hex);
                    self._renderCanvas();
                    self._renderToTarget();
                },
                onChange: function(hsb, hex, rgb) {
                    $element.find('.point-color div').css('backgroundColor', '#' + hex);
                    _selPoint.css('backgroundColor', '#' + hex);
                    self._renderCanvas();
                    self._renderToTarget();
                }
            });
            $(document).bind('click', function() {
                if (!$element.is('.hover')) {
                    $pointsInfos.hide('fast');
                }
            });
            _canvas.unbind('click');
            _canvas.bind('click', function(e) {
                var offset = _canvas.offset(), clickPosition = e.pageX - offset.left;
                clickPosition = Math.round((clickPosition * 100) / self.settings.width);
                var defaultColor = '#000000', minDist = 999999999999;
                $.each(points, function(i, el) {
                    if ((parseInt(el[0]) < clickPosition) && (clickPosition - parseInt(el[0]) < minDist)) {
                        minDist = clickPosition - parseInt(el[0]);
                        defaultColor = el[1];
                    }
                    else if ((parseInt(el[0]) > clickPosition) && (parseInt(el[0]) - clickPosition < minDist)) {
                        minDist = parseInt(el[0]) - clickPosition;
                        defaultColor = el[1];
                    }
                });
                points.push([clickPosition + '%', defaultColor]);
                points.sort(self._sortByPosition);
                self._render();
                $.each(points, function(i, el) {
                    if (el[0] == clickPosition + '%') {
                        self._selectPoint($pointsContainer.find('.point:eq(' + i + ')'));
                    }
                });
            });
        };
        this._render = function() {
            this._initGradientPoints();
            this._renderCanvas();
            this._renderToTarget();
        };
        this._initGradientPoints = function() {
            var self = this;
            $pointsContainer.empty();
            $.each(points, function(i, el) {
                $pointsContainer.append('<div class="point" style="background-color: ' + el[1] + '; left:' + (parseInt(el[0]) * self.settings.width) / 100 + 'px;"></div>');
            });
            $pointsContainer.find('.point').css('width', this.settings.point + 'px').css('height', this.settings.point + 'px').mouseup(function() {
                self._selectPoint(this);
            }).draggable({
                axis: 'x',
                containment: 'parent',
                drag: function() {
                    self._selectPoint(this);
                    self._renderCanvas();
                    self._renderToTarget();
                }
            });
        };
        this._selectPoint = function(el) {
            var self = this;
            _selPoint = $(el);
            var color = $(el).css('backgroundColor'), position = parseInt($(el).css('left'));
            position = Math.round((position / this.settings.width) * 100);
            color = color.substr(4, color.length);
            color = color.substr(0, color.length - 1);
            $pointColor.ColorPickerSetColor(this._rgbToHex(color.split(',')));
            $pointColor.find('div').css('backgroundColor', this._rgbToHex(color.split(',')));
            $pointPosition.html('Position: ' + position + '%');
            $btnPointDelete.unbind('click').bind('click', function() {
                if (points.length > 1) {
                    points.splice(_selPoint.index(), 1);
                    self._render();
                    $element.find('.info').hide('fast');
                }
                return false;
            });
            $element.find('.info').css('marginLeft', parseInt($(el).css('left')) - 30 + 'px').show('fast');
        };
        this._renderCanvas = function() {
            var self = this;
            points = new Array();
            $element.find('.point').each(function(i, el) {
                var position = Math.round((parseInt($(el).css('left')) / self.settings.width) * 100);
                var color = $(el).css('backgroundColor').substr(4, $(el).css('backgroundColor').length - 5);
                color = self._rgbToHex(color.split(','));
                points.push([position + '%', color]);
            });
            points.sort(self._sortByPosition);
            this._renderToCanvas();
            this.settings.onChange(this.getString(), this.getCSS(), this.getArray());
        };
        this._renderToElement = function(target, gradient) {
            var svgX = '0%', svgY = '100%', webkitDir = 'left bottom', defDir = 'top';
            if ((target === _canvas) || (this.settings.orientation === 'horizontal')) {
                svgX = '100%';
                svgY = '0%';
                webkitDir = 'right top';
                defDir = 'left';
            }
			
			defDir = this.settings.orientation; // hack by amit
            
			var svg = '<svg xmlns="http://www.w3.org/2000/svg">' + '<defs>' + '<linearGradient id="gradient" x1="0%" y1="0%" x2="' + svgX + '" y2="' + svgY + '">';
            var webkitCss = '-webkit-gradient(linear, left top, ' + webkitDir;
            var defCss = '';
            $.each(gradient, function(i, el) {
                webkitCss += ', color-stop(' + el[0] + ', ' + el[1] + ')';
                defCss += ',' + el[1] + ' ' + el[0] + '';
                svg += '<stop offset="' + el[0] + '" style="stop-color:' + el[1] + ';" />';
            });
            webkitCss += ')';
            defCss = defCss.substr(1);
            svg += '</linearGradient>' + '</defs>';
            if (target === $pointsInfosContent) {
                var tooltipRadius = parseInt($pointsInfosContent.css('borderRadius'));
                svg += '<rect fill="url(#gradient)" height="100%" width="100%" rx="' + tooltipRadius + '" ry="' + tooltipRadius + '" />';
            }
            else {
                svg += '<rect fill="url(#gradient)" height="100%" width="100%" />';
            }
            svg += '</svg>';
            svg = this._base64(svg);
            target.css('background', 'url(data:image/svg+xml;base64,' + svg + ')');
            target.css('background', webkitCss);
            target.css('background', '-moz-linear-gradient(' + defDir + ',' + defCss + ')');
            target.css('background', '-webkit-linear-gradient(' + defDir + ',' + defCss + ')');
            target.css('background', '-o-linear-gradient(' + defDir + ',' + defCss + ')');
            target.css('background', '-ms-linear-gradient(' + defDir + ',' + defCss + ')');
            target.css('background', 'linear-gradient(' + defDir + ',' + defCss + ')');
        };
        this._renderToTarget = function() {
            if (this.settings.target !== null) {
                this._renderToElement($(this.settings.target), points);
            }
        };
        this._renderToCanvas = function() {
            var gradient = _context.createLinearGradient(0, 0, this.settings.width, 0);
            $.each(points, function(i, el) {
                gradient.addColorStop(parseInt(el[0]) / 100, el[1]);
            });
            _context.clearRect(0, 0, this.settings.width, this.settings.height);
            _context.fillStyle = gradient;
            _context.fillRect(0, 0, this.settings.width, this.settings.height);
            this.settings.onChange(this.getString(), this.getCSS(), this.getArray());
        };
        this._getGradientFromString = function(gradient) {
            var arr = new Array(), _t = gradient.split(',');
            $.each(_t, function(i, el) {
                var position;
                if ((el.substr(el.indexOf('%') - 3, el.indexOf('%')) == '100') || (el.substr(el.indexOf('%') - 3, el.indexOf('%')) == '100%')) {
                    position = '100%';
                }
                else if (el.indexOf('%') > 1) {
                    position = parseInt(el.substr(el.indexOf('%') - 2, el.indexOf('%')));
                    position += '%';
                }
                else {
                    position = parseInt(el.substr(el.indexOf('%') - 1, el.indexOf('%')));
                    position += '%';
                }
                var color = el.substr(el.indexOf('#'), 7);
                arr.push([position, color]);
            });
            return arr;
        };
        this._rgbToHex = function(rgb) {
            var R = rgb[0], G = rgb[1], B = rgb[2];
            function toHex(n) {
                n = parseInt(n, 10);
                if (isNaN(n))
                    return "00";
                n = Math.max(0, Math.min(n, 255));
                return "0123456789ABCDEF".charAt((n - n % 16) / 16) + "0123456789ABCDEF".charAt(n % 16);
            }
            return '#' + toHex(R) + toHex(G) + toHex(B);
        };
        this._sortByPosition = function(data_A, data_B) {
            if (parseInt(data_A[0]) < parseInt(data_B[0])) {
                return -1;
            }
            if (parseInt(data_A[0]) > parseInt(data_B[0])) {
                return 1;
            }
            return 0;
        };
        this._base64 = function(input) {
            var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", output = "", chr1, chr2, chr3, enc1, enc2, enc3, enc4, i = 0;
            while (i < input.length) {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                }
                else if (isNaN(chr3)) {
                    enc4 = 64;
                }
                output += keyStr.charAt(enc1) + keyStr.charAt(enc2) + keyStr.charAt(enc3) + keyStr.charAt(enc4);
            }
            return output;
        };
        return this.__constructor();
    };
    $.fn.ClassyGradient = function(options) {
        return this.each(function() {
            if ($(this).data('ClassyGradient') === undefined) {
                var plugin = new $.ClassyGradient(this, options);
                $(this).data('ClassyGradient', plugin);
            }
        });
    };
})(jQuery);