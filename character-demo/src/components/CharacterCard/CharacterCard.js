import React from 'react';
import './CharacterCard.scss';


class CharacterCard extends React.Component {

  

    render() {

        return (
            <div className="card" onClick={this.props.clickCard} >
                <img src={this.props.character.image} alt="Avatar" style={{width: '100%'}} />
                <div className="container">
                    <b>{this.props.character.name}</b>
                </div>
            </div>
        );

    }

}

export default CharacterCard;