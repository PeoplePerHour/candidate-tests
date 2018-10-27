import React, { PureComponent } from 'react';
import cn from 'classnames';

import Downshift from 'downshift';
import { Button } from '../../Common';
import './Filter.scss';

class Filter extends PureComponent {
  onChange = selected => {
    this.props.onChange(selected);
  };

  render() {
    const { initial, data, withTextInput, inputProps, children } = this.props;

    return (
      <Downshift
        initialSelectedItem={initial}
        onSelect={this.onChange}
        itemToString={item => (item ? item : '')}
      >
        {({
          getToggleButtonProps,
          selectedItem,
          getItemProps,
          isOpen,
          clearSelection
        }) => (
          <div className="Filter">
            <div
              className={cn('Filter__trigger', {
                'Filter__trigger--active':
                  !!selectedItem || (inputProps && !!inputProps.value)
              })}
            >
              <Button {...getToggleButtonProps()} plain>
                <span>{children}</span>
                <span style={{ marginLeft: 20 }}>⯆</span>
              </Button>
            </div>
            {!isOpen ? null : (
              <div className={cn('Filter__items', { open: isOpen })}>
                {withTextInput && <input type="text" {...inputProps} />}
                <div className="Filter__items-options">
                  {data.map((item, index) => (
                    <Button
                      key={item}
                      plain
                      active={selectedItem === item}
                      id={item}
                      value={item}
                      style={{
                        textAlign: 'left'
                      }}
                      {...getItemProps({
                        item,
                        index
                      })}
                      onClick={e => {
                        if (selectedItem === item) {
                          clearSelection(e);
                        } else {
                          getItemProps({ item, index }).onClick(e);
                        }
                      }}
                    >
                      <span
                        style={{
                          display: 'flex',
                          justifyContent: 'space-between'
                        }}
                      >
                        <span>{item}</span>
                        <span>{selectedItem === item ? '✅' : ''}</span>
                      </span>
                    </Button>
                  ))}
                </div>
                <Button plain onClick={clearSelection}>
                  clear filter
                </Button>
              </div>
            )}
          </div>
        )}
      </Downshift>
    );
  }
}

export default Filter;
