import React, { Component } from 'react';
import './ItemComponent.sass';


export class ItemComponent extends Component {


  render() {
    const {onClick} = this.props;
    const {id, image, name, gender, species, status, origin, } = this.props.item;

    return (
      <div className="item" gid={id} title={name} onClick={onClick}>
        <div className="itemInner">
          <div className="imgContainer"><img src={image} alt={name}/></div>
          <h2 className="name">{name}</h2>
          <div className="sepLine"></div>
          <div className="extraInfo">
            <table>
              <tbody>
                <tr>
                  <td>
                    <table>
                      <tbody>
                        <tr><td className="infot">Gender</td><td className="infos">{gender}</td></tr>
                        <tr><td className="infot">Species</td><td className="infos">{species}</td></tr>
                        <tr><td className="infot">Status</td><td className="infos">{status}</td></tr>
                        <tr><td className="infot">Origin</td><td className="infos">{origin.name}</td></tr>
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
