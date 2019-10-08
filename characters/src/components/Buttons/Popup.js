import React from 'react'

class Popup extends React.Component {
    render () {
        if (this.props.loading) {
            return <div className='loading'>Loading
            <div className="spinner-border spinner" role="status">   
          </div></div>
        } else {
        return (
            <div className='pop-container'>
                <div className='pop-name'>
                    <h3>{this.props.characterInfo.name}</h3>
                </div>
                    <img className='pop-img' src={this.props.characterInfo.image} alt='img' height="120" width="120"></img>
                        <div className="meta-title">
                            <h5>Full Info</h5>
                        </div>    
                    <div className="pop-info">
                            <h6 className='meta-items'><b className='pbol'>ID:</b>    <i className='pital'>{this.props.characterInfo.id}</i> </h6>
                            <h6 className='meta-items'><b className='pbol'>Status:</b> <i className='pital'>{this.props.characterInfo.status}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Gender:</b> <i className='pital'>{this.props.characterInfo.gender}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Species:</b> <i className='pital'>{this.props.characterInfo.species}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Episodes:</b> <i className='pital'>{this.props.characterInfo.episode.length}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Type:</b> <i className='pital'>{this.props.characterInfo.type}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Origin:</b> <i className='pital'>{this.props.characterInfo.origin.name}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Location:</b> <i className='pital'>{this.props.characterInfo.location.name}</i></h6>
                            <h6 className='pop-items'><b className='pbol'>Character url:</b>    <i className='pital'>{this.props.characterInfo.url}</i> </h6>
                            <h6 className='meta-items'><b className='pbol'>Origin url:</b> <i className='pital'>{this.props.characterInfo.origin.url}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Location url:</b> <i className='pital'>{this.props.characterInfo.location.url}</i></h6>
                            <h6 className='meta-items'><b className='pbol'>Created:</b> <i className='pital'>{this.props.characterInfo.created}</i></h6>
                    </div>  
            </div>
        )}
    }       
}
  
export default Popup;
