/*
 * PEACH
 * Migrate database.
 * Author: Pete Saia
 */

exports.init = function (grunt) {
	'use strict';

	var PEACH = {};

	PEACH.migrate = function (haystack, old_domain, new_domain, callback) {
		if (!haystack || !old_domain || !new_domain) {
			return false;
		}
		
		if (!(this instanceof PEACH.migrate)) {
			return new PEACH.migrate(haystack, old_domain, new_domain, callback);
		}
		
		this.haystack       = haystack;
		this.new_haystack   = haystack;
		this.old_domain     = old_domain;
		this.new_domain     = new_domain;
		this.char_diff      = null;
		this.processed      = false;
		this.identifier     = '§∆';
		this.callback       = callback || false;
		
		grunt.log.writeln('Migrating from ' + old_domain + ' to ' + new_domain + '.');
	};
	PEACH.migrate.prototype = {
		init: function () {
			this._set_char_diff();
			this._handle_serializations();
			this._handle_other_domains();
			this._remove_identifier();
			this._processed = true;
			if (this.callback) {
				this.callback(this.get_processed_file());
			}
			
			grunt.log.writeln('Complete!');
		},
		
		get_processed_file: function () {
			return this._processed ? this.new_haystack : null;
		},
		
		_handle_serializations: function () {
			var exp = /s:(\d+):(.+?)\\"/ig,
					serials,
					stack,
					found = 0;
			
			while ((serials = exp.exec(this.new_haystack)) != null) {
				if (serials[2].indexOf(this.old_domain) === -1) {
					continue;
				}
				stack = this._split_stack(exp.lastIndex - serials[0].length, exp.lastIndex);
				stack[1] = this._replace_char_int(stack[1], this._new_char_int(serials[1]));
				stack[1] = stack[1].replace(this.old_domain, this.new_domain + this.identifier);
				this.new_haystack = stack.join('');
				found++;
			}
			grunt.log.writeln(found + ' serialized links found.');
		},
		
		_handle_other_domains: function () {
			var exp = new RegExp(PEACH.migrate.reg_escape(this.old_domain) + "(.+?(\r|\n|'|\"))?", "gi"),
					matches = 0,
					that = this,
					replacement;
			
			this.new_haystack = this.new_haystack.replace(exp, function ($0, $1) {
				if ($0.indexOf(that.identifier) === -1) {
					replacement = $0.replace(new RegExp(PEACH.migrate.reg_escape(that.old_domain), "gi"), that.new_domain);
					matches++;
				}
				else {
					matches--;
					replacement = $0;
				}
				return replacement;
			});
			grunt.log.writeln('Replaced ' + matches + ' other links.');
		},
		
		_split_stack: function (from, to) {
			var stack = [];
			stack.push(this.new_haystack.substring(0, from));
			stack.push(this.new_haystack.substring(from, to));
			stack.push(this.new_haystack.substring(to));
			return stack;
		},
		
		_new_char_int: function (charint) {
			var old_int = parseInt(charint, 10),
					new_int;
			if (this.char_diff > 0) {
				new_int = old_int - Math.abs(this.char_diff);
			}
			else if (this.char_diff < 0) {
				new_int = old_int + Math.abs(this.char_diff);
			}
			else {
				new_int = old_int;
			}
			return new_int;
		},
		
		_replace_char_int: function (str, char_int) {
			return str.replace(/(s:)?\d+/, function ($0, $1) {
				return $1 ? $1 + char_int : $0;
			});
		},
		
		_remove_identifier: function () {
			this.new_haystack = this.new_haystack.replace(new RegExp(this.identifier, "g"), '');
		},
		
		_set_char_diff: function () {
			this.char_diff = this.old_domain.length - this.new_domain.length;
			grunt.log.writeln('Domain character difference: ' + this.char_diff + '.');
		}
	};

	PEACH.migrate.reg_escape = function (str) {
		var specials = ['/', '.', '*', '+', '?', '|',
				'(', ')', '[', ']', '{', '}'],
				len = specials.length;
		
		for (var i = 0; len > i; i++) {
			str = str.replace(new RegExp("\\" + specials[i], "gi"), "\\" + specials[i]);
		}
		
		return str;
	};

	return PEACH;
};
