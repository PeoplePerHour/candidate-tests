import React from 'react';
import Popup from './Buttons/Popup'
import NewPopup from 'reactjs-popup';


const CharactersList = (props) => {
    return (
        <div className="content" onClick={props.loadingState}>
            {props.characters.map(character => 
                <div className='item' key={character.id}>
                    <div className='img' >
                        <div>
                            <NewPopup className='pop-wrapper' trigger={
                                <div>        
                                <img src={character.image} alt="img" height="200" width="209" className='cimg' onClick={props.clickPopup} id={character.id}></img>
                                    <h4 className='name' onClick={props.clickPopup} id={character.id}><b>{character.name}</b> </h4>
                                </div> 
                                } position='right center'> 
                                <div className='pop-wrapper'>
                                    <Popup {...props}></Popup>
                                </div>
                            </NewPopup>
                        </div>
                        
                                <div className='header'  onClick={props.toggleCharInfo}>
                                    <h5><i id={character.id}>Basic Info</i>
                                    <i className="address book icon" ></i>      
                                    </h5>
                                </div>
                    </div>
                    
                    <div className='meta' id={character.id} 
                    style={{display: props.toggleInfo ? 'block' : 'none' }}>
                        <h6 className='meta-items'><b className='bol'>ID:</b>    <i className='ital'>{character.id}</i> </h6>
                        <h6 className='meta-items'><b className='bol'>Gender:</b> <i className='ital'>{character.gender}</i></h6>
                        <h6 className='meta-items'><b className='bol'>Status:</b> <i className='ital'>{character.status}</i></h6>
                        <h6 className='meta-items'><b className='bol'>Species:</b> <i className='ital'>{character.species}</i></h6>
                    </div>  
                </div>
            )}        
        </div>       
    )}
export default CharactersList;
