import React from 'react';
import './Modal.scss';

class Modal extends React.Component {
        

    render() {

        
    
        if(this.props.isShown) {

            let heShe = this.props.selectedCharacter.gender === 'Male' ? 'He' :(this.props.selectedCharacter.gender === 'Female' ? 'She' : 'It');
            let beOrNot = this.props.selectedCharacter.status === 'Alive' ? 'lives' : (this.props.selectedCharacter.status === 'Dead' ? 'used to live' : 'probably lives') ;

        return (
            <div>
                <div className="modal-overlay" onClick={this.props.onOverlay} />
                  <div className="modal-content">
                     <div><img src={this.props.selectedCharacter.image} alt="Avatar" style={{width: '100%'}} /></div>
                            <b>{this.props.selectedCharacter.name}</b>
                            <b>{heShe} is {this.props.selectedCharacter.species}</b>
                            {/* <b>{heShe} is {this.props.selectedCharacter.gender}</b> */}
                            <b>{this.props.selectedCharacter.status} status</b>
                            <b>{heShe} {beOrNot} in {this.props.selectedCharacter.location.name}</b>
                        </div>
                   </div>
        );
            // }
        }else {
            return null;
        }

    }

}

export default Modal;