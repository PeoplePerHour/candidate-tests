'use strict';

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
	var p = '',
	    k = void 0,
	    u = [];
	for (k in obj) {
		if (obj[k]) {
			u.push(encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]));
		}
	}
	if (u[0]) {
		p = '?';
	}
	return p + u.join('&');
}

function saveHistory(obj, serialized) {
	var url = [location.protocol, '//', location.host, location.pathname].join('');
	var fullURL = url + serialized;
	history.pushState(JSON.parse(JSON.stringify(obj)), 'queryStringUrl', fullURL);
}

function jsonNormalizer(results, normalisedJSON) {
	var THAT = this;
	var gen = normalisedJSON['genders'];
	var spe = normalisedJSON['species'];
	var sta = normalisedJSON['statuses'];
	var typ = normalisedJSON['types'];
	var epi = normalisedJSON['episodes'];
	var geo = normalisedJSON['geo'];
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
			geo[results[u].location.name] = {
				name: results[u].location.name,
				url: results[u].location.url
			};
		}
		if (!geo[results[u].origin.name]) {
			geo[results[u].origin.name] = {
				name: results[u].origin.name,
				url: results[u].origin.url
			};
		}
	}

	normalisedJSON['genders'] = [].concat(_toConsumableArray(new Set(gen)));
	normalisedJSON['species'] = [].concat(_toConsumableArray(new Set(spe)));
	normalisedJSON['statuses'] = [].concat(_toConsumableArray(new Set(sta)));
	normalisedJSON['types'] = [].concat(_toConsumableArray(new Set(typ)));
	normalisedJSON['episodes'] = [].concat(_toConsumableArray(new Set(epi)));
	normalisedJSON['characters'] = [];
	normalisedJSON['locations'] = [];
	for (var m in geo) {
		normalisedJSON['locations'].push(geo[m]);
	}

	var _loop = function _loop(_u) {
		var c = {
			id: results[_u].id,
			name: results[_u].name,
			created: results[_u].created,
			gender: gen.indexOf(results[_u].gender),
			species: spe.indexOf(results[_u].species),
			status: sta.indexOf(results[_u].status),
			type: typ.indexOf(results[_u].type),
			episode: results[_u].episode.map(function (v) {
				return epi.indexOf(v);
			}),
			origin: normalisedJSON['locations'].findIndex(function (item) {
				return item.name === results[_u].origin.name;
			}),
			location: normalisedJSON['locations'].findIndex(function (item) {
				return item.name === results[_u].location.name;
			})
		};
		normalisedJSON['characters'].push(c);
	};

	for (var _u = 0; _u < results.length; _u++) {
		_loop(_u);
	}
	console.log('NORMALISED JSON AFTER GET request');
	return normalisedJSON;
};

/**
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
   *	initial values for normalised JSON response.
   *		
   *  genders,species,statuses,types,episodes,locations 
   *  will grow after each request based on unique elements found on each response.
   */
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

				var data = response.data;
				state.searched.prevURL = data.info.prev;
				state.searched.nextURL = data.info.next;
				state.searched.totalPages = data.info.pages;
				state.searched.results = data.results;

				ReactDOM.render(React.createElement(CharacterList, {
					results: data.results
				}), document.getElementById('results'));

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

var Filters = function (_React$Component) {
	_inherits(Filters, _React$Component);

	function Filters(props) {
		_classCallCheck(this, Filters);

		var _this = _possibleConstructorReturn(this, (Filters.__proto__ || Object.getPrototypeOf(Filters)).call(this));

		_this.state = {
			gender: '',
			status: '',
			species: '',
			page: 0
		};

		_this.goSearch = _this.goSearch.bind(_this);

		var THAT = _this;
		window.addEventListener('popstate', function (event) {
			THAT.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
			THAT.goSearch(false);
		}, false);

		return _this;
	}

	_createClass(Filters, [{
		key: 'goSearch',
		value: function goSearch(history) {
			this.props.dispatch({ type: 'DO_SEARCH', pushHistory: history });
			var obj = {
				gender: this.props.searched.filters.gender,
				status: this.props.searched.filters.status,
				species: this.props.searched.filters.species,
				page: this.props.searched.filters.page
			};
			this.setState(obj);
		}
	}, {
		key: 'componentDidMount',
		value: function componentDidMount() {
			this.props.dispatch({ type: 'UPDATE_FILTERS_BY_URL' });
			this.goSearch(true);
		}
	}, {
		key: 'render',
		value: function render() {
			var _this2 = this;

			return React.createElement(
				'div',
				{ 'class': 'search-filters' },
				React.createElement(
					'button',
					{ 'class': 'nav-but',
						onClick: function onClick(ev) {
							_this2.props.dispatch({ type: 'GO_BACK' });
							_this2.goSearch(true);
						}
					},
					'\xAB Previous'
				),
				React.createElement(
					'button',
					{ 'class': 'nav-but',
						onClick: function onClick(ev) {
							_this2.props.dispatch({ type: 'GO_NEXT' });
							_this2.goSearch(true);
						}
					},
					'Next \xBB'
				),
				React.createElement(
					'div',
					{ 'class': 'filter-block' },
					React.createElement(
						'h2',
						{ 'class': 'filter-title' },
						'Gender'
					),
					React.createElement(GenderFilter, {
						gender: this.state.gender,
						updateFilter: function updateFilter(ev) {
							_this2.props.dispatch({ type: 'UPDATE_FILTER', prop: 'gender', val: ev.target.value });
							_this2.goSearch(true);
						}
					})
				),
				React.createElement(
					'div',
					{ 'class': 'filter-block' },
					React.createElement(
						'h2',
						{ 'class': 'filter-title' },
						'Status'
					),
					React.createElement(StatusFilter, {
						status: this.state.status,
						updateFilter: function updateFilter(ev) {
							_this2.props.dispatch({ type: 'UPDATE_FILTER', prop: 'status', val: ev.target.value });
							_this2.goSearch(true);
						}
					})
				),
				React.createElement(
					'div',
					{ 'class': 'filter-block' },
					React.createElement(
						'h2',
						{ 'class': 'filter-title' },
						'Species'
					),
					React.createElement(SpeciesFilter, {
						species: this.state.species,
						updateFilter: function updateFilter(ev) {
							_this2.props.dispatch({ type: 'UPDATE_FILTER', prop: 'species', val: ev.target.value });
							_this2.goSearch(true);
						}
					})
				)
			);
		}
	}]);

	return Filters;
}(React.Component);

var CharacterList = function (_React$Component2) {
	_inherits(CharacterList, _React$Component2);

	function CharacterList(props) {
		_classCallCheck(this, CharacterList);

		var _this3 = _possibleConstructorReturn(this, (CharacterList.__proto__ || Object.getPrototypeOf(CharacterList)).call(this));

		_this3.state = {};
		return _this3;
	}

	_createClass(CharacterList, [{
		key: 'render',
		value: function render() {
			return React.createElement(
				'div',
				{ 'class': 'search-results' },
				React.createElement(
					'div',
					{ 'class': 'results-header' },
					React.createElement(
						'h2',
						{ 'class': 'title' },
						'Characters'
					)
				),
				React.createElement(
					'div',
					{ 'class': 'results-body' },
					this.props.results.map(function (x, k) {
						return React.createElement(Character, {
							index: k,
							charName: x.name,
							charProfile: x
						});
					})
				)
			);
		}
	}]);

	return CharacterList;
}(React.Component);

var Character = function (_React$Component3) {
	_inherits(Character, _React$Component3);

	function Character(props) {
		_classCallCheck(this, Character);

		var _this4 = _possibleConstructorReturn(this, (Character.__proto__ || Object.getPrototypeOf(Character)).call(this));

		_this4.showCharProfile = _this4.showCharProfile.bind(_this4);
		return _this4;
	}

	_createClass(Character, [{
		key: 'showCharProfile',
		value: function showCharProfile(profile) {
			ReactDOM.render(React.createElement(CharacterDetails, {
				profile: profile,
				display: 'none'
			}), document.getElementById('modal'));
		}
	}, {
		key: 'render',
		value: function render() {
			var _this5 = this;

			return React.createElement(
				'div',
				null,
				React.createElement('span', null),
				React.createElement(
					'h1',
					{ 'class': 'search-item',
						onClick: function onClick(e) {
							_this5.showCharProfile(_this5.props.charProfile);
						}
					},
					this.props.charName
				)
			);
		}
	}]);

	return Character;
}(React.Component);

var Image = function (_React$Component4) {
	_inherits(Image, _React$Component4);

	function Image(props) {
		_classCallCheck(this, Image);

		var _this6 = _possibleConstructorReturn(this, (Image.__proto__ || Object.getPrototypeOf(Image)).call(this));

		_this6.state = {
			srcZ: null,
			img: 'inline-block',
			fallback: 'none'
		};

		_this6.loadFallback = _this6.loadFallback.bind(_this6);
		return _this6;
	}

	_createClass(Image, [{
		key: 'loadFallback',
		value: function loadFallback() {
			this.setState({
				img: 'none',
				fallback: 'inline-block'
			});
			console.log('error loading image');
			this.props.showProfile();
		}
	}, {
		key: 'loadImageSource',
		value: function loadImageSource() {
			var _this7 = this;

			var addImageProcess = function addImageProcess(src) {
				return new Promise(function (resolve, reject) {
					var img = new Image();
					img.onload = resolve(img);
					img.onerror = reject(img);
					img.src = src;
				});
			};

			addImageProcess(this.props.sourceZ).then(function (u) {
				_this7.setState({
					srcZ: _this7.props.sourceZ,
					img: 'inline-block',
					fallback: 'none'
				});
			}, function (err) {
				console.log("rejected: ", err);
				_this7.setState({
					srcZ: _this7.props.sourceZ,
					img: 'none',
					fallback: 'inline-block'
				});
			});
		}
	}, {
		key: 'componentDidMount',
		value: function componentDidMount() {
			this.loadImageSource();
		}
	}, {
		key: 'componentDidUpdate',
		value: function componentDidUpdate(prevProps) {
			if (prevProps.sourceZ && prevProps.sourceZ === this.props.sourceZ) {
				return;
			}
			this.loadImageSource();
		}
	}, {
		key: 'render',
		value: function render() {
			return React.createElement(
				'div',
				{ style: { display: 'inline-block' } },
				React.createElement('img', { alt: '',
					style: { display: this.state.img },
					src: this.state.srcZ,
					onLoad: this.props.showProfile,
					onError: this.loadFallback
				}),
				React.createElement(
					'span',
					{
						style: { width: '200px', display: this.state.fallback }
					},
					'NO IMAGE SRC'
				)
			);
		}
	}]);

	return Image;
}(React.Component);

var CharacterDetails = function (_React$Component5) {
	_inherits(CharacterDetails, _React$Component5);

	function CharacterDetails(props) {
		_classCallCheck(this, CharacterDetails);

		var _this8 = _possibleConstructorReturn(this, (CharacterDetails.__proto__ || Object.getPrototypeOf(CharacterDetails)).call(this));

		_this8.state = {
			loaded: false,
			display: 'none'
		};

		_this8.showIt = _this8.showIt.bind(_this8);
		_this8.getEpisodeNumber = _this8.getEpisodeNumber.bind(_this8);
		return _this8;
	}

	_createClass(CharacterDetails, [{
		key: 'componentDidUpdate',
		value: function componentDidUpdate(prevProps) {
			this.state.display = 'none';
			this.state.loaded = false;
		}
	}, {
		key: 'showIt',
		value: function showIt() {
			this.setState({
				loaded: true,
				display: 'block'
			});
		}
	}, {
		key: 'getEpisodeNumber',
		value: function getEpisodeNumber(v) {
			return v.match(/\d+$/);
		}
	}, {
		key: 'render',
		value: function render() {
			var _this9 = this;

			return React.createElement(
				'div',
				{ 'class': 'custom-modal',
					style: { display: this.state.display },
					onClick: function onClick() {
						_this9.setState({ display: 'none' });
					}
				},
				React.createElement(
					'div',
					{ 'class': 'modal-body' },
					React.createElement(
						'div',
						{ 'class': 'closer' },
						React.createElement(
							'a',
							{ href: '#',
								onClick: function onClick() {
									_this9.setState({ display: 'none' });
								}
							},
							'Close'
						)
					),
					React.createElement(
						'div',
						{ 'class': 'portait' },
						React.createElement(Image, {
							sourceZ: this.props.profile.image,
							showProfile: this.showIt
						})
					),
					React.createElement(
						'div',
						{ 'class': 'primary-properties' },
						React.createElement(
							'div',
							null,
							React.createElement(
								'h2',
								null,
								'name'
							),
							React.createElement(
								'h3',
								null,
								this.props.profile.name || 'not defined'
							)
						),
						React.createElement(
							'div',
							null,
							React.createElement(
								'h2',
								null,
								'gender'
							),
							React.createElement(
								'h3',
								null,
								this.props.profile.gender || 'not defined'
							)
						),
						React.createElement(
							'div',
							null,
							React.createElement(
								'h2',
								null,
								'status'
							),
							React.createElement(
								'h3',
								null,
								this.props.profile.status || 'not defined'
							)
						),
						React.createElement(
							'div',
							null,
							React.createElement(
								'h2',
								null,
								'species'
							),
							React.createElement(
								'h3',
								null,
								this.props.profile.species || 'not defined'
							)
						),
						React.createElement(
							'div',
							null,
							React.createElement(
								'h2',
								null,
								'type'
							),
							React.createElement(
								'h3',
								null,
								this.props.profile.type || 'not defined'
							)
						),
						React.createElement(
							'div',
							null,
							React.createElement(
								'h2',
								null,
								'created:'
							),
							React.createElement(
								'h3',
								null,
								this.props.profile.created || 'not defined'
							)
						)
					),
					React.createElement(
						'div',
						{ 'class': 'secondary-properties' },
						React.createElement(
							'div',
							{ 'class': 'episodes' },
							React.createElement(
								'h3',
								null,
								'Episodes'
							),
							this.props.profile.episode.map(function (x) {
								return React.createElement(
									'h3',
									{ 'class': 'episode' },
									_this9.getEpisodeNumber(x)
								);
							})
						),
						React.createElement(
							'div',
							{ 'class': 'location' },
							React.createElement(
								'span',
								{ 'class': 'title' },
								'Location : '
							),
							React.createElement(
								'a',
								{
									href: this.props.profile.location.url
								},
								this.props.profile.location.name
							)
						),
						React.createElement(
							'div',
							{ 'class': 'origin' },
							React.createElement(
								'span',
								{ 'class': 'title' },
								'Origin : '
							),
							React.createElement(
								'a',
								{
									href: this.props.profile.origin.url
								},
								this.props.profile.origin.name
							)
						),
						React.createElement(
							'h1',
							{ 'class': 'details' },
							React.createElement(
								'a',
								{
									href: this.props.profile.url
								},
								'Details'
							)
						)
					)
				)
			);
		}
	}]);

	return CharacterDetails;
}(React.Component);

var GenderFilter = function (_React$Component6) {
	_inherits(GenderFilter, _React$Component6);

	function GenderFilter(props) {
		_classCallCheck(this, GenderFilter);

		var _this10 = _possibleConstructorReturn(this, (GenderFilter.__proto__ || Object.getPrototypeOf(GenderFilter)).call(this));

		_this10.selectOptions = [{ value: '', name: 'no selection' }, { value: 'male', name: 'male' }, { value: 'female', name: 'female' }];
		console.log("props", props);
		return _this10;
	}

	_createClass(GenderFilter, [{
		key: 'render',
		value: function render() {
			return React.createElement(
				'select',
				{ 'class': 'dropd-filter',
					value: this.props.gender,
					onChange: this.props.updateFilter
				},
				this.selectOptions.map(function (x) {
					return React.createElement(
						'option',
						{
							value: x.value
						},
						x.name
					);
				})
			);
		}
	}]);

	return GenderFilter;
}(React.Component);

var SpeciesFilter = function (_React$Component7) {
	_inherits(SpeciesFilter, _React$Component7);

	function SpeciesFilter(props) {
		_classCallCheck(this, SpeciesFilter);

		var _this11 = _possibleConstructorReturn(this, (SpeciesFilter.__proto__ || Object.getPrototypeOf(SpeciesFilter)).call(this));

		_this11.selectOptions = [{ value: '', name: 'no selection' }, { value: 'alien', name: 'alien' }, { value: 'human', name: 'human' }, { value: 'unknown', name: 'unknown' }, { value: 'mytholog', name: 'mytholog' }, { value: 'Poopybutthole', name: 'Poopybutthole' }, { value: 'humanoid', name: 'humanoid' }];
		return _this11;
	}

	_createClass(SpeciesFilter, [{
		key: 'render',
		value: function render() {
			return React.createElement(
				'select',
				{ 'class': 'dropd-filter',
					value: this.props.species,
					onChange: this.props.updateFilter
				},
				this.selectOptions.map(function (x) {
					return React.createElement(
						'option',
						{
							value: x.value
						},
						x.name
					);
				})
			);
		}
	}]);

	return SpeciesFilter;
}(React.Component);

var StatusFilter = function (_React$Component8) {
	_inherits(StatusFilter, _React$Component8);

	function StatusFilter(props) {
		_classCallCheck(this, StatusFilter);

		var _this12 = _possibleConstructorReturn(this, (StatusFilter.__proto__ || Object.getPrototypeOf(StatusFilter)).call(this));

		_this12.selectOptions = [{ value: '', name: 'no selection' }, { value: 'unknown', name: 'unknown' }, { value: 'alive', name: 'alive' }, { value: 'dead', name: 'dead' }];
		return _this12;
	}

	_createClass(StatusFilter, [{
		key: 'render',
		value: function render() {
			return React.createElement(
				'select',
				{ 'class': 'dropd-filter',
					value: this.props.status,
					onChange: this.props.updateFilter
				},
				this.selectOptions.map(function (x) {
					return React.createElement(
						'option',
						{
							value: x.value
						},
						x.name
					);
				})
			);
		}
	}]);

	return StatusFilter;
}(React.Component);

/**
 *  Create store
 */

var store = Redux.createStore(searchEngine);

/**
 *	 Connect react components
 */

var ConnFilters = ReactRedux.connect(function (state) {
	return state;
})(Filters);

var ConnResults = ReactRedux.connect(function (state) {
	return state;
})(CharacterList);

var ConnProfile = ReactRedux.connect(function (state) {
	return state;
})(CharacterDetails);

/**
 *  Subscribe to render CharacterList
 */

function renderResults() {
	var currentState = store.getState();
	ReactDOM.render(React.createElement(CharacterList, {
		results: currentState.searched.results
	}), document.getElementById('results'));
	console.log("results updated");
}

store.subscribe(renderResults);

ReactDOM.render(React.createElement(
	ReactRedux.Provider,
	{ store: store },
	React.createElement(ConnFilters, null)
), document.getElementById('root'));