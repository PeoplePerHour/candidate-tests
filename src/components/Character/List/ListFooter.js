import React, { PureComponent } from 'react';

import { Button } from '../../Common';
import { parseParamsFromLink } from '../../../utils';

import './ListFooter.scss';

class CharacterListFooter extends PureComponent {
  onClick = link => () => {
    const params = parseParamsFromLink(link);
    this.props.onClick(params);
  };

  render() {
    const { info } = this.props;

    return info.pages > 1 ? (
      <div className="CharacterListFooter">
        <Button
          color="orange"
          disabled={!info.prev}
          onClick={this.onClick(info.prev)}
        >
          Previous
        </Button>
        <Button disabled={!info.next} onClick={this.onClick(info.next)}>
          Next
        </Button>
      </div>
    ) : null;
  }
}

export default CharacterListFooter;
