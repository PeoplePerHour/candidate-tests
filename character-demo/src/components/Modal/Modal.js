import React from 'react';
import './Modal.scss';
import { withRouter } from 'react-router-dom';

const Modal = (props) => {
        

    // render() {

        // console.log(props);
    
        if(props.isShown) {

            let heShe = props.selectedCharacter.gender === 'Male' ? 'He' :(props.selectedCharacter.gender === 'Female' ? 'She' : 'It');
            let beOrNot = props.selectedCharacter.status === 'Alive' ? 'lives' : (props.selectedCharacter.status === 'Dead' ? 'used to live' : 'probably lives') ;

        return (
            <div>
                <div className="modal-overlay" onClick={props.onOverlay} />
                  <div className="modal-content">
                     <div><img src={props.selectedCharacter.image} alt="Avatar" style={{width: '100%'}} /></div>
                            <b>{props.selectedCharacter.name}</b>
                            <b>{heShe} is {props.selectedCharacter.species}</b>
                            {/* <b>{heShe} is {this.props.selectedCharacter.gender}</b> */}
                            <b>{props.selectedCharacter.status} status</b>
                            <b>{heShe} {beOrNot} in {props.selectedCharacter.location.name}</b>
                        </div>
                   </div>
        );
            // }
        }else {
            return null;
        }

    // }

}

export default withRouter(Modal);