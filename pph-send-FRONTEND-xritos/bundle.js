"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

function getParameterByName(name, url) {
	var params = new URLSearchParams(location.search.slice(1));
	return params;
}

function serializeObj(obj) {
	var p = void 0,
	    k = void 0,
	    u = [];
	for (k in obj) {
		if (obj[k]) {
			u.push(encodeURIComponent(k) + "=" + encodeURIComponent(obj[k]));
		}
	}
	if (u[0]) {
		p = "?";
	} else {
		p = "";
	}
	return p + u.join('&');
}

function saveHistory(obj, serialized) {
	var url = [location.protocol, '//', location.host, location.pathname].join('');
	var fullURL = url + serialized;
	history.pushState(JSON.parse(JSON.stringify(obj)), "queryStringUrl", fullURL);
}

function jsonNormalizer(results, normalisedJSON) {

	var THAT = this;

	var gen = normalisedJSON["genders"];
	var spe = normalisedJSON["species"];
	var sta = normalisedJSON["statuses"];
	var typ = normalisedJSON["types"];
	var epi = normalisedJSON["episodes"];

	var geo = normalisedJSON["geo"];

	var ids = [];
	for (var u = 0; u < results.length; u++) {

		if (results[u].gender) {
			gen.push(results[u].gender);
		}
		if (results[u].species) {
			spe.push(results[u].species);
		}
		if (results[u].status) {
			sta.push(results[u].status);
		}
		if (results[u].type) {
			typ.push(results[u].type);
		}

		results[u].episode.map(function (x) {
			epi.push(x);
		});

		if (!geo[results[u].location.name]) {
			geo[results[u].location.name] = { name: results[u].location.name, url: results[u].location.url };
		}
		if (!geo[results[u].origin.name]) {
			geo[results[u].origin.name] = { name: results[u].origin.name, url: results[u].origin.url };
		}
	}

	normalisedJSON["genders"] = [].concat(_toConsumableArray(new Set(gen)));
	normalisedJSON["species"] = [].concat(_toConsumableArray(new Set(spe)));
	normalisedJSON["statuses"] = [].concat(_toConsumableArray(new Set(sta)));
	normalisedJSON["types"] = [].concat(_toConsumableArray(new Set(typ)));
	normalisedJSON["episodes"] = [].concat(_toConsumableArray(new Set(epi)));

	normalisedJSON["locations"] = [];
	for (var m in geo) {
		normalisedJSON["locations"].push(geo[m]);
	}

	normalisedJSON["characters"] = [];

	var _loop = function _loop(_u) {

		var c = { id: results[_u].id,
			name: results[_u].name,
			created: results[_u].created,
			gender: gen.indexOf(results[_u].gender),
			species: spe.indexOf(results[_u].species),
			status: sta.indexOf(results[_u].status),
			type: typ.indexOf(results[_u].type),
			episode: results[_u].episode.map(function (v) {
				return epi.indexOf(v);
			}),
			origin: normalisedJSON["locations"].findIndex(function (item) {
				return item.name === results[_u].origin.name;
			}),
			location: normalisedJSON["locations"].findIndex(function (item) {
				return item.name === results[_u].location.name;
			})
		};
		normalisedJSON["characters"].push(c);
	};

	for (var _u = 0; _u < results.length; _u++) {
		_loop(_u);
	}
	console.log("NORMALISED JSON AFTER GET request");

	return normalisedJSON;
};

var Filters = function (_React$Component) {
	_inherits(Filters, _React$Component);

	function Filters(props) {
		_classCallCheck(this, Filters);

		var _this = _possibleConstructorReturn(this, (Filters.__proto__ || Object.getPrototypeOf(Filters)).call(this));

		_this.goSearch = function (history) {
			_this.props.dispatch({ type: 'DO_SEARCH', pushHistory: history });
			var obj = {
				gender: _this.props.searched.filters.gender,
				status: _this.props.searched.filters.status,
				species: _this.props.searched.filters.species,
				page: _this.props.searched.filters.page
			};
			_this.setState(obj);
		};

		_this.state = {

			gender: '',
			status: '',
			species: '',
			page: 0
		};

		var THAT = _this;
		window.addEventListener('popstate', function (event) {
			THAT.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
			THAT.goSearch(false);
		}, false);

		return _this;
	}

	_createClass(Filters, [{
		key: "componentDidMount",
		value: function componentDidMount() {
			this.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
			this.goSearch(true);
		}
	}, {
		key: "render",
		value: function render() {
			var _this2 = this;

			return React.createElement(
				"div",
				{ "class": "search-filters" },
				React.createElement(
					"button",
					{ "class": "nav-but", onClick: function onClick(ev) {
							_this2.props.dispatch({ type: 'GO_BACK' });_this2.goSearch(true);
						} },
					"\xAB Previous"
				),
				React.createElement(
					"button",
					{ "class": "nav-but", onClick: function onClick(ev) {
							_this2.props.dispatch({ type: 'GO_NEXT' });_this2.goSearch(true);
						} },
					"Next \xBB"
				),
				React.createElement(
					"div",
					{ "class": "filter-block" },
					React.createElement(
						"h2",
						{ "class": "filter-title" },
						"Gender"
					),
					React.createElement(GenderFilter, { gender: this.state.gender, updateFilter: function updateFilter(ev) {
							_this2.props.dispatch({ type: 'UPDATE_FILTER', prop: 'gender', val: ev.target.value });_this2.goSearch(true);
						} })
				),
				React.createElement(
					"div",
					{ "class": "filter-block" },
					React.createElement(
						"h2",
						{ "class": "filter-title" },
						"Status"
					),
					React.createElement(StatusFilter, { status: this.state.status, updateFilter: function updateFilter(ev) {
							_this2.props.dispatch({ type: 'UPDATE_FILTER', prop: 'status', val: ev.target.value });_this2.goSearch(true);
						} })
				),
				React.createElement(
					"div",
					{ "class": "filter-block" },
					React.createElement(
						"h2",
						{ "class": "filter-title" },
						"Species"
					),
					React.createElement(SpeciesFilter, { species: this.state.species, updateFilter: function updateFilter(ev) {
							_this2.props.dispatch({ type: 'UPDATE_FILTER', prop: 'species', val: ev.target.value });_this2.goSearch(true);
						} })
				)
			);
		}
	}]);

	return Filters;
}(React.Component);

var GenderFilter = function (_React$Component2) {
	_inherits(GenderFilter, _React$Component2);

	function GenderFilter(props) {
		_classCallCheck(this, GenderFilter);

		var _this3 = _possibleConstructorReturn(this, (GenderFilter.__proto__ || Object.getPrototypeOf(GenderFilter)).call(this));

		_this3.selectOptions = [{ value: '', name: 'no selection' }, { value: 'male', name: 'male' }, { value: 'female', name: 'female' }];
		console.log("props", props);
		return _this3;
	}

	_createClass(GenderFilter, [{
		key: "render",
		value: function render() {
			return React.createElement(
				"select",
				{ "class": "dropd-filter", value: this.props.gender, onChange: this.props.updateFilter },
				this.selectOptions.map(function (x) {
					return React.createElement(SelectOption, { optionValue: x.value, optionName: x.name });
				})
			);
		}
	}]);

	return GenderFilter;
}(React.Component);

var StatusFilter = function (_React$Component3) {
	_inherits(StatusFilter, _React$Component3);

	function StatusFilter(props) {
		_classCallCheck(this, StatusFilter);

		var _this4 = _possibleConstructorReturn(this, (StatusFilter.__proto__ || Object.getPrototypeOf(StatusFilter)).call(this));

		_this4.selectOptions = [{ value: '', name: 'no selection' }, { value: 'unknown', name: 'unknown' }, { value: 'alive', name: 'alive' }, { value: 'dead', name: 'dead' }];
		return _this4;
	}

	_createClass(StatusFilter, [{
		key: "render",
		value: function render() {
			return React.createElement(
				"select",
				{ "class": "dropd-filter", value: this.props.status, onChange: this.props.updateFilter },
				this.selectOptions.map(function (x) {
					return React.createElement(SelectOption, { optionValue: x.value, optionName: x.name });
				})
			);
		}
	}]);

	return StatusFilter;
}(React.Component);

var SpeciesFilter = function (_React$Component4) {
	_inherits(SpeciesFilter, _React$Component4);

	function SpeciesFilter(props) {
		_classCallCheck(this, SpeciesFilter);

		var _this5 = _possibleConstructorReturn(this, (SpeciesFilter.__proto__ || Object.getPrototypeOf(SpeciesFilter)).call(this));

		_this5.selectOptions = [{ value: '', name: 'no selection' }, { value: 'alien', name: 'alien' }, { value: 'human', name: 'human' }, { value: 'unknown', name: 'unknown' }, { value: 'mytholog', name: 'mytholog' }, { value: 'Poopybutthole', name: 'Poopybutthole' }, { value: 'humanoid', name: 'humanoid' }];
		return _this5;
	}

	_createClass(SpeciesFilter, [{
		key: "render",
		value: function render() {
			return React.createElement(
				"select",
				{ "class": "dropd-filter", value: this.props.species, onChange: this.props.updateFilter },
				this.selectOptions.map(function (x) {
					return React.createElement(SelectOption, { optionValue: x.value, optionName: x.name });
				})
			);
		}
	}]);

	return SpeciesFilter;
}(React.Component);

var SelectOption = function (_React$Component5) {
	_inherits(SelectOption, _React$Component5);

	function SelectOption() {
		_classCallCheck(this, SelectOption);

		return _possibleConstructorReturn(this, (SelectOption.__proto__ || Object.getPrototypeOf(SelectOption)).apply(this, arguments));
	}

	_createClass(SelectOption, [{
		key: "render",
		value: function render() {
			return React.createElement(
				"option",
				{ value: this.props.optionValue },
				this.props.optionName
			);
		}
	}]);

	return SelectOption;
}(React.Component);

var Results = function (_React$Component6) {
	_inherits(Results, _React$Component6);

	function Results(props) {
		_classCallCheck(this, Results);

		var _this7 = _possibleConstructorReturn(this, (Results.__proto__ || Object.getPrototypeOf(Results)).call(this));

		_this7.state = {};
		return _this7;
	}

	_createClass(Results, [{
		key: "render",
		value: function render() {
			return React.createElement(
				"div",
				{ "class": "search-results" },
				React.createElement(
					"div",
					{ "class": "results-header" },
					React.createElement(
						"h2",
						{ "class": "title" },
						"Characters"
					)
				),
				React.createElement(
					"div",
					{ "class": "results-body" },
					this.props.results.map(function (x, k) {
						assert.isObject(x, 'each item of results in response must be object');
						assert.property(x, 'name', 'name property must exist in every item of results');

						return React.createElement(Character, { index: k, charName: x.name, charProfile: x });
					})
				)
			);
		}
	}]);

	return Results;
}(React.Component);

var Character = function (_React$Component7) {
	_inherits(Character, _React$Component7);

	function Character() {
		var _ref;

		var _temp, _this8, _ret2;

		_classCallCheck(this, Character);

		for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
			args[_key] = arguments[_key];
		}

		return _ret2 = (_temp = (_this8 = _possibleConstructorReturn(this, (_ref = Character.__proto__ || Object.getPrototypeOf(Character)).call.apply(_ref, [this].concat(args))), _this8), _this8.showCharProfile = function (profile) {

			assert.containsAllKeys(profile, ["created", "episode", "gender", "id", "image", "location", "name", "origin", "species", "status", "type", "url"], "required propries missing");

			ReactDOM.render(React.createElement(CharacterDetails, { profile: profile, display: 'none' }), document.getElementById('modal'));
		}, _temp), _possibleConstructorReturn(_this8, _ret2);
	}

	_createClass(Character, [{
		key: "render",
		value: function render() {
			var _this9 = this;

			return React.createElement(
				"div",
				null,
				React.createElement("span", null),
				" ",
				React.createElement(
					"h1",
					{ "class": "search-item", onClick: function onClick(e) {
							_this9.showCharProfile(_this9.props.charProfile);
						} },
					this.props.charName
				)
			);
		}
	}]);

	return Character;
}(React.Component);

var CharacterDetails = function (_React$Component8) {
	_inherits(CharacterDetails, _React$Component8);

	function CharacterDetails(props) {
		_classCallCheck(this, CharacterDetails);

		var _this10 = _possibleConstructorReturn(this, (CharacterDetails.__proto__ || Object.getPrototypeOf(CharacterDetails)).call(this));

		_this10.showIt = function () {
			_this10.setState({ loaded: true, display: 'block' });
		};

		_this10.state = {
			loaded: false,
			display: 'none'
		};
		return _this10;
	}

	_createClass(CharacterDetails, [{
		key: "componentDidUpdate",
		value: function componentDidUpdate(prevProps) {
			this.state.display = "none";
			this.state.loaded = false;
		}
	}, {
		key: "render",
		value: function render() {
			var _this11 = this;

			return React.createElement(
				"div",
				{ "class": "custom-modal", style: { display: this.state.display }, onClick: function onClick() {
						_this11.setState({ display: 'none' });
					} },
				React.createElement(
					"div",
					{ "class": "modal-body" },
					React.createElement(
						"div",
						{ "class": "closer" },
						React.createElement(
							"a",
							{ href: "#", onClick: function onClick() {
									_this11.setState({ display: 'none' });
								} },
							"Close"
						)
					),
					React.createElement(
						"div",
						{ "class": "portait" },
						React.createElement(Image, { sourceZ: this.props.profile.image, showProfile: this.showIt }),
						" "
					),
					React.createElement(
						"div",
						{ "class": "primary-properties" },
						React.createElement(
							"div",
							null,
							React.createElement(
								"h2",
								null,
								"name"
							),
							"  ",
							React.createElement(
								"h3",
								null,
								this.props.profile.name || 'not defined',
								" "
							)
						),
						React.createElement(
							"div",
							null,
							React.createElement(
								"h2",
								null,
								"gender"
							),
							" ",
							React.createElement(
								"h3",
								null,
								this.props.profile.gender || 'not defined',
								" "
							)
						),
						React.createElement(
							"div",
							null,
							React.createElement(
								"h2",
								null,
								"status"
							),
							" ",
							React.createElement(
								"h3",
								null,
								this.props.profile.status || 'not defined',
								" "
							)
						),
						React.createElement(
							"div",
							null,
							React.createElement(
								"h2",
								null,
								"species"
							),
							" ",
							React.createElement(
								"h3",
								null,
								this.props.profile.species || 'not defined',
								" "
							)
						),
						React.createElement(
							"div",
							null,
							React.createElement(
								"h2",
								null,
								"type"
							),
							"  ",
							React.createElement(
								"h3",
								null,
								this.props.profile.type || 'not defined',
								" "
							)
						),
						React.createElement(
							"div",
							null,
							React.createElement(
								"h2",
								null,
								"created:"
							),
							" ",
							React.createElement(
								"h3",
								null,
								this.props.profile.created || 'not defined',
								" "
							)
						)
					),
					React.createElement(
						"div",
						{ "class": "secondary-properties" },
						React.createElement(Episodes, { episodes: this.props.profile.episode }),
						React.createElement(Location, { location: this.props.profile.location }),
						React.createElement(Origin, { origin: this.props.profile.origin }),
						React.createElement(
							"h1",
							{ "class": "details" },
							React.createElement(
								"a",
								{ href: this.props.profile.url },
								"Details"
							)
						)
					)
				)
			);
		}
	}]);

	return CharacterDetails;
}(React.Component);

var Image = function (_React$Component9) {
	_inherits(Image, _React$Component9);

	function Image(props) {
		_classCallCheck(this, Image);

		var _this12 = _possibleConstructorReturn(this, (Image.__proto__ || Object.getPrototypeOf(Image)).call(this));

		_this12.la = function () {
			_this12.setState({ img: 'none', fallback: 'inline-block' });console.log("error loading image");_this12.props.showProfile();
		};

		_this12.loadImageSource = function () {

			var addImageProcess = function addImageProcess(src) {
				return new Promise(function (resolve, reject) {
					var img = new Image();
					img.onload = resolve(img);
					img.onerror = reject(img);
					img.src = src;
				});
			};

			addImageProcess(_this12.props.sourceZ).then(function (u) {
				_this12.setState({ srcZ: _this12.props.sourceZ, img: 'inline-block', fallback: 'none' });
			}, function (err) {
				console.log("rejected: ", err);
				_this12.setState({ srcZ: _this12.props.sourceZ, img: 'none', fallback: 'inline-block' });
			});
		};

		_this12.state = { srcZ: null, img: 'inline-block', fallback: 'none' };
		return _this12;
	}

	_createClass(Image, [{
		key: "componentDidMount",
		value: function componentDidMount() {
			this.loadImageSource();
		}
	}, {
		key: "componentDidUpdate",
		value: function componentDidUpdate(prevProps) {

			if (prevProps.sourceZ && prevProps.sourceZ === this.props.sourceZ) {
				return;
			}

			this.loadImageSource();
		}
	}, {
		key: "render",
		value: function render() {
			return React.createElement(
				"div",
				{ style: { display: 'inline-block' } },
				React.createElement("img", { style: { display: this.state.img }, src: this.state.srcZ, onLoad: this.props.showProfile, onError: this.la }),
				React.createElement(
					"span",
					{ style: { width: '200px', display: this.state.fallback } },
					"NO IMAGE SRC"
				)
			);
		}
	}]);

	return Image;
}(React.Component);

var Episodes = function (_React$Component10) {
	_inherits(Episodes, _React$Component10);

	function Episodes() {
		_classCallCheck(this, Episodes);

		return _possibleConstructorReturn(this, (Episodes.__proto__ || Object.getPrototypeOf(Episodes)).apply(this, arguments));
	}

	_createClass(Episodes, [{
		key: "render",
		value: function render() {
			return React.createElement(
				"div",
				{ "class": "episodes" },
				React.createElement(
					"h3",
					{ style: { padding: "0px" } },
					"Episodes"
				),
				this.props.episodes.map(function (x) {
					return React.createElement(Episode, { episodeName: x });
				})
			);
		}
	}]);

	return Episodes;
}(React.Component);

var Episode = function (_React$Component11) {
	_inherits(Episode, _React$Component11);

	function Episode() {
		var _ref2;

		var _temp2, _this14, _ret3;

		_classCallCheck(this, Episode);

		for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
			args[_key2] = arguments[_key2];
		}

		return _ret3 = (_temp2 = (_this14 = _possibleConstructorReturn(this, (_ref2 = Episode.__proto__ || Object.getPrototypeOf(Episode)).call.apply(_ref2, [this].concat(args))), _this14), _this14.regNo = function (v) {

			return v.match(/\d+$/);
		}, _temp2), _possibleConstructorReturn(_this14, _ret3);
	}

	_createClass(Episode, [{
		key: "render",
		value: function render() {

			return React.createElement(
				"h3",
				{ "class": "episode" },
				this.regNo(this.props.episodeName)
			);
		}
	}]);

	return Episode;
}(React.Component);

var Location = function (_React$Component12) {
	_inherits(Location, _React$Component12);

	function Location() {
		_classCallCheck(this, Location);

		return _possibleConstructorReturn(this, (Location.__proto__ || Object.getPrototypeOf(Location)).apply(this, arguments));
	}

	_createClass(Location, [{
		key: "render",
		value: function render() {

			return React.createElement(
				"div",
				{ "class": "location" },
				React.createElement(
					"span",
					{ "class": "title" },
					"Location : "
				),
				React.createElement(
					"a",
					{ href: this.props.location.url },
					this.props.location.name
				)
			);
		}
	}]);

	return Location;
}(React.Component);

var Origin = function (_React$Component13) {
	_inherits(Origin, _React$Component13);

	function Origin() {
		_classCallCheck(this, Origin);

		return _possibleConstructorReturn(this, (Origin.__proto__ || Object.getPrototypeOf(Origin)).apply(this, arguments));
	}

	_createClass(Origin, [{
		key: "render",
		value: function render() {

			return React.createElement(
				"div",
				{ "class": "origin" },
				React.createElement(
					"span",
					{ "class": "title" },
					"Origin : "
				),
				React.createElement(
					"a",
					{ href: this.props.origin.url },
					this.props.origin.name
				)
			);
		}
	}]);

	return Origin;
}(React.Component);

var assert = chai.assert;
var should = chai.should;
var expect = chai.expect;

/*
 *		Init redux store
 */

var initialState = {
	searched: {
		results: [],
		filters: {
			page: 0,
			gender: '',
			status: '',
			species: ''
		},
		url: '',
		/**	
  	initial values for normalised JSON response.
  	
  	genders,species,statuses,types,episodes,locations 
  	will grow after each request based on unique elements found on each response.
  **/
		normalisedJSON: {

			genders: [],
			species: [],
			statuses: [],
			types: [],
			episodes: [],
			locations: [],

			geo: {}, /*temporary to help with locations */
			characters: []
		},
		prevURL: '',
		nextURL: '',
		totalPages: ''
	}
};

function searchEngine() {
	var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : initialState;
	var action = arguments[1];

	if (typeof state === 'undefined') {
		return initialState;
	}
	switch (action.type) {

		case 'DO_SEARCH':

			var s = serializeObj(state.searched.filters);
			var URL = 'https://rickandmortyapi.com/api/character/' + s;

			axios.get(URL).then(function (response) {

				assert.isObject(response.data, 'response is not an object');
				assert.exists(response.data.results, 'results is  `null` or `undefined`');
				assert.isArray(response.data.results, 'results is not array');

				var data = response.data;

				state.searched.prevURL = data.info.prev;
				state.searched.nextURL = data.info.next;
				state.searched.totalPages = data.info.pages;
				state.searched.results = data.results;

				ReactDOM.render(React.createElement(Results, { results: data.results }), document.getElementById('results'));

				if (action.pushHistory && action.pushHistory === true) {
					saveHistory(state.searched.filters, s);
				}
				/** Prints in console Normalised Response **/
				jsonNormalizer(data.results, state.searched.normalisedJSON);
			}).catch(function (error) {
				console.log("error", error);
			});
			return state;
		case 'UPDATE_FILTER':
			if (action.prop != 'page') {
				state.searched.filters.page = 0;
			}
			state.searched.filters[action.prop] = action.val;
			return state;
		case 'UPDATE_FILTERS_BY_URL':
			var queryStrings = getParameterByName();
			state.searched.filters.gender = queryStrings.get("gender") || '';
			state.searched.filters.status = queryStrings.get("status") || '';
			state.searched.filters.species = queryStrings.get("species") || '';
			state.searched.filters.page = queryStrings.get("page") || 0;
			return state;
		case 'GO_NEXT':
			if (state.searched.nextURL) {
				state.searched.filters.page = state.searched.nextURL.match(/page=([\d]+)/)[1];
			} else {
				state.searched.filters.page = state.searched.totalPages ? Math.min(state.searched.filters.page + 1, state.searched.totalPages) : parseInt(state.searched.filters.page + 1, 10);
			}
			return state;
		case 'GO_BACK':
			if (state.searched.prevURL) {
				state.searched.filters.page = state.searched.prevURL.match(/page=([\d]+)/)[1];
			} else {
				state.searched.filters.page = Math.max(state.searched.filters.page - 1, 0);
			}
			return state;
		case 'NORMALIZE_RESPONSE':
			jsonNormalizer(state.searched.results, state.searched.normalisedJSON);
			return state;
		default:
			return state;
	}
	return state;
}

var store = Redux.createStore(searchEngine);

/*
*		Connect react components
*/

var ConnFilters = ReactRedux.connect(function (state) {
	return state;
})(Filters);

var ConnResults = ReactRedux.connect(function (state) {
	return state;
})(Results);

var ConnProfile = ReactRedux.connect(function (state) {
	return state;
})(CharacterDetails);

function middle() {

	var re = store.getState();
	ReactDOM.render(React.createElement(Results, { results: re.searched.results }), document.getElementById('results'));
	console.log("results updated");
}

store.subscribe(middle);

ReactDOM.render(React.createElement(
	ReactRedux.Provider,
	{ store: store },
	React.createElement(ConnFilters, null)
), document.getElementById('root'));