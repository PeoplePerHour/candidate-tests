
function getParameterByName(name, url) {
			let 	params = new URLSearchParams(location.search.slice(1));
			return 	params;
}

function serializeObj(obj) {
			let p,k,u=[];
			for(  k in obj )
			{
				if( obj[k] )
				{
					u.push(`${encodeURIComponent(k)}=${encodeURIComponent(obj[k])}`);
				}
			}
			if( u[0] ) { p = "?";}else{p = "";}
			return p + u.join('&');
}

function saveHistory(obj, serialized ) {
			let url				= 	[location.protocol, '//', location.host, location.pathname].join('');
			let fullURL			= 	url	+ serialized ;
			history.pushState( JSON.parse(JSON.stringify(obj)) , "queryStringUrl" , fullURL );			
}

function jsonNormalizer(results, normalisedJSON) {
	
			let THAT = this;
			
			let gen = normalisedJSON["genders"	];
			let spe = normalisedJSON["species"	];
			let sta = normalisedJSON["statuses"];
			let typ	= normalisedJSON["types"	];			
			let epi = normalisedJSON["episodes"];
			
			let geo = normalisedJSON["geo"];
			
			let ids	= [];
			for(let u = 0; u < results.length; u++){
											
				if (results[u].gender)	{ gen.push( results[u].gender 	); }
				if (results[u].species)	{ spe.push( results[u].species	); }
				if (results[u].status)	{ sta.push( results[u].status 	); }
				if (results[u].type) 	{ typ.push( results[u].type 		); }
				
				results[u].episode.map(	(x) => 	{																
												epi.push( x );																
									} 
				);
				
				if( 	!geo[ results[u].location.name ] 		)
				{
									geo[ results[u].location.name ] =  { name: results[u].location.name , url: results[u].location.url };
				}
				if( 	!geo[ results[u].origin.name ] 		)
				{
									geo[ results[u].origin.name ] =  { name: results[u].origin.name , url: results[u].origin.url };
				}				
			}
			
			normalisedJSON["genders"	] 	= [...new Set(gen)]; 
			normalisedJSON["species"	] 	= [...new Set(spe)]; 
			normalisedJSON["statuses"] 		= [...new Set(sta)]; 
			normalisedJSON["types"	] 		= [...new Set(typ)]; 
			normalisedJSON["episodes"	] 	= [...new Set(epi)]; 
		
			normalisedJSON["locations"	] 	= [];			
			for(let m in geo){																	
					normalisedJSON["locations"	].push( geo[m] );																
			}						
					
			normalisedJSON[ "characters" ] = [];		
			for(let u = 0; u < results.length; u++){
				
					let c = {	id				: results[u].id						,
								name			: results[u].name						,	
								created			: results[u].created					,
								gender 			: gen.indexOf( results[u].gender 	)	,
								species			: spe.indexOf( results[u].species 	) 	,
								status 			: sta.indexOf( results[u].status  	) 	,
								type 			: typ.indexOf( results[u].type 		)	,				
								episode			: results[u].episode.map(	v =>	epi.indexOf( v ) 	)	,								
								origin			: normalisedJSON["locations"].findIndex( item => item.name === results[u].origin.name 	),
								location		: normalisedJSON["locations"].findIndex( item => item.name === results[u].location.name 	)									
					};
					normalisedJSON[ "characters" ].push( c );
			}			
			console.log( "NORMALISED JSON AFTER GET request" );
			
			return normalisedJSON;
};