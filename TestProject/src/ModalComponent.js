import React, { Component } from 'react';
import './ModalComponent.sass';


export class Modal extends Component {

  constructor(){
    super();

    this.state ={
      episodes : undefined,
      load : 'waiting'
    };

    this.fetchEpisodes = this.fetchEpisodes.bind(this);
    this.extractEpisodeIds = this.extractEpisodeIds.bind(this);
    this.itemsFetched = this.itemsFetched.bind(this);
  }

  itemsFetched(result){
    if(result !== undefined) {
      if(result instanceof Array) this.setState({ episodes: result, load: 'loaded' });
      else this.setState({ episodes: [result], load: 'loaded' });
    }
  }

  fetchEpisodes(str){
    let url = 'https://rickandmortyapi.com/api/episode/' + str;
    this.setState({ load: 'loading' });
    setTimeout(() => {
      fetch(url)
        .then(responce => responce.json())
        .then(result => this.itemsFetched(result))
        .catch(error => error);
    }, 800);
  }

  extractEpisodeIds(arr){
    const newarr = arr.map((item,index)=>{
      const tempar = item.split("/");
      return tempar[tempar.length -1];
    });
    return newarr.join(',');
  }

  componentDidMount(){
    this.fetchEpisodes(this.extractEpisodeIds(this.props.item.episode));
  }

  render() {
    const {item, close} = this.props;
    const {id, type, name, image, gender, species, status, location, origin} = item;
    return (
      <div className="modal">
        <div className="modalInner">
          <div className="closeBar"><div className="close" onClick={close}><span></span></div></div>

          <img alt={name} src={image} className="image" title={name}/>
          <div className="extraBigTitle"><span>{name}</span></div>

          <div className="extraInfo">
            <table>
              <tbody>
                <tr>
                  <td>
                    <table>
                      <tbody>
                        <tr><td className="infot">ID</td><td className="infos">{id}</td></tr>
                        <tr><td className="infot">Gender</td><td className="infos">{gender}</td></tr>
                        <tr><td className="infot">Species</td><td className="infos">{species}</td></tr>
                        <tr><td className="infot">Type</td><td className="infos">{type || '-'}</td></tr>
                        <tr><td className="infot">Status</td><td className="infos">{status}</td></tr>
                        <tr><td className="infot">Origin</td><td className="infos">{origin.name}</td></tr>
                        <tr><td className="infot">Location</td><td className="infos">{location.name}</td></tr>
                        {this.state.load === 'loading' &&
                        <tr><td colSpan="2">
                            <div className="loader">
                              <div className="loaderLine"></div>
                            </div>
                        </td></tr>}
                        {this.state.episodes !== undefined &&
                          <tr><td className="infot">Episodes</td><td className="infos">
                          {this.state.episodes.map((item,i,j)=>{
                            return(
                              <span key={i}>{item.name}</span>
                            );
                          })}
                        </td></tr>}
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }
}
