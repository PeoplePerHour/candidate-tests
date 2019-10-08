import React from 'react'

const Status = (props) => {
    return (
        <div className='drop-item'>
            <select className="drop-status" value={props.statusValue} 
                onChange={props.statusUpdate}>
                <option value="">Status</option>
                <option value="dead">Dead</option>
                <option value="alive">Alive</option>
                <option value="unknown">Unknown</option>                 
            </select> 
        </div>
    )
}

export default Status
