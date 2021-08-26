import React, { useEffect, useState, memo } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { useHistory } from 'react-router-dom'
import {
  CButton,
  CCard,
  CCardBody,
  CCardHeader,
  CCol,
  CDropdown,
  CDropdownItem,
  CDropdownMenu,
  CDropdownToggle,
  CForm,
  CFormGroup,
  CInput,
  CInputGroup,
  CInputGroupAppend,
  CInputGroupPrepend,
  CPagination,
  CRow,
  CSelect,
} from '@coreui/react'
import CIcon from '@coreui/icons-react'

import { getData } from '../../redux/actions/character'
import { getQueryFromURL } from '../../utility/Utils'
 
const statusColorMap = {
  Alive: 'bg-success',
  Dead: 'bg-secondary',
  unknown: 'bg-warning',
}

const genderOptions = [
  'Male',
  'Female',
  'unknown',
]

const statusOptions = [
  'Alive',
  'Dead',
  'unknown',
]

const Characters = () => {
  const history = useHistory()
  const dispatch = useDispatch()
  const store = useSelector(state => state.characters)

  const [currentData, setCurrentData] = useState([])
  const [currentPage, setCurrentPage] = useState(1)
  const [totalPage, setTotalPage] = useState(1)
  const [currentFilter, setCurrentFilter] = useState('Name')
  const [filter, setFilter] = useState('')

  useEffect(() => {
    const query = getQueryFromURL(window.location.href)
    if (query !== undefined) {
      switch (query.key) {
        case 'name':
          setCurrentFilter('Name')
          break;
        case 'gender':
          setCurrentFilter('Gender')
          break;
        case 'status':
          setCurrentFilter('Status')
          break;
        default: ;
      }
      setFilter(query.value)
    }
    if (query)
      dispatch(getData([
        query
      ]))
    else dispatch(getData())
  }, [dispatch])

  useEffect(() => {
    setCurrentData(store.data)
    setCurrentPage(store.page)
    setTotalPage(store.info.pages)
  }, [store])

  const handleCurrentPageChanged = (idx) => {
    setCurrentPage(idx)
    dispatch( getData([
      {key: currentFilter.toLowerCase(), value: filter.toLowerCase()},
      {key: 'page', value: idx},
    ]) )
  }

  const handleFilterToggle = (value) => {
    setCurrentFilter(value)
    setFilter('')
  }

  const handleSearch = () => {
    if(filter === '') history.replace('/characters')
    else history.replace(`/characters/?${currentFilter.toLowerCase()}=${filter.toLowerCase()}`)
    dispatch( getData([{key: currentFilter.toLowerCase(), value: filter.toLowerCase()}]) )
  }

  const handleReset = () => {
    setFilter('')
    history.replace('/characters')
    dispatch( getData() )
  }

  const handleFilterChange = (ele) => {
    let value = ''

    if (currentFilter === 'Name') value = ele.target.value
    else if (currentFilter === 'Gender') value = genderOptions[ele.target.options.selectedIndex - 1]
    else value = statusOptions[ele.target.options.selectedIndex - 1]

    if (value === undefined) value = ''
    setFilter(value)
  }

  return (
    <>
      <CRow>
        <CCol>
          <CCard>
            <CCardHeader>
              Character List
            </CCardHeader>
            <CCardBody className="overflow-auto">
              <div className="ml-1 mr-5 d-flex justify-content-between align-items-center">
                <CForm action="" method="" className="form-horizontal" onSubmit={(e) => {e.preventDefault()}}>
                  <CFormGroup row>
                    <CCol md="12">
                      <CInputGroup>
                        <CInputGroupPrepend className="my-1">
                          <CDropdown className="input-group-prepend">
                            <CDropdownToggle caret color="primary">
                              {currentFilter}
                            </CDropdownToggle>
                            <CDropdownMenu>
                              <CDropdownItem onClick={() => handleFilterToggle('Name')}>Name</CDropdownItem>
                              <CDropdownItem onClick={() => handleFilterToggle('Gender')}>Gender</CDropdownItem>
                              <CDropdownItem onClick={() => handleFilterToggle('Status')}>Status</CDropdownItem>
                            </CDropdownMenu>
                          </CDropdown>
                        </CInputGroupPrepend>
                        {
                          currentFilter === 'Name' ? 
                            <CInput id="input1-group2" className="m-1" name="input1-group2" value={filter} placeholder={currentFilter} onChange={handleFilterChange} />
                          :
                            <CSelect custom className="m-1" name="select" id="select" value={filter.toLowerCase()} onChange={handleFilterChange}>
                              <option value={''}>{currentFilter === 'Gender' ? 'Select Gender' : 'Select Status'}</option>
                              {
                                currentFilter === 'Gender' ? 
                                  genderOptions.map((gender, index) => {
                                    return (
                                      <option key={index} value={gender.toLowerCase()}>{gender}</option>
                                    )
                                  })
                                :
                                  statusOptions.map((status, index) => {
                                    return (
                                      <option key={index} value={status.toLowerCase()}>{status}</option>
                                    )
                                  })
                              }
                            </CSelect>
                        }
                        <CInputGroupAppend className="my-1">
                          <CButton type="button" color="primary" onClick={handleSearch}><CIcon className="m-0"  name="cil-magnifying-glass" /> Search</CButton>
                          <CButton type="button" className="ml-1" color="primary" onClick={handleReset}>Reset</CButton>
                        </CInputGroupAppend>
                      </CInputGroup>
                    </CCol>
                  </CFormGroup>
                </CForm>
                <div>
                  <span className="mx-1 d-none d-sm-block">
                    <strong>currentPage: {currentPage}</strong>
                  </span>
                  <span className="mx-1 d-none d-sm-block">
                    <strong>totalPage: {totalPage}</strong>
                  </span>
                </div>
              </div>
              <br></br>

              <table className="table table-hover table-outline mb-0 d-table">
                <thead className="thead-light">
                  <tr>
                    <th className="text-center"><CIcon name="cil-people" /></th>
                    <th>Name</th>
                    <th>Species</th>
                    <th className="text-center">Gender</th>
                    <th className="d-none d-sm-table-cell">Origin</th>
                    <th className="d-none d-sm-table-cell">Location</th>
                  </tr>
                </thead>
                <tbody>
                  {
                    currentData.map((data, index) => {
                      return (
                        <tr key={index}>
                          <td className="text-center">
                            <div className="c-avatar">
                              <img src={data.image} className="c-avatar-img" alt="admin@bootstrapmaster.com" />
                              <span className={`c-avatar-status ${statusColorMap[data.status]}`}></span>
                            </div>
                          </td>
                          <td>
                            <div>{data.name}</div>
                          </td>
                          <td>
                            <div>{data.species}</div>
                          </td>
                          <td className="text-center">
                            <div>{data.gender}</div>
                          </td>
                          <td className="d-none d-sm-table-cell">
                            <div className="small text-muted">{data.origin.name}</div>
                          </td>
                          <td className="d-none d-sm-table-cell">
                            <div className="small text-muted">{data.location.name}</div>
                          </td>
                        </tr>
                      )
                    })
                  }
                </tbody>
              </table>
              <br></br>
              
              <div className="mx-5 d-flex justify-content-between align-items-center">
                <span className="mx-1 d-none d-sm-inline">
                  <strong>currentPage: {currentPage}</strong>
                </span>
                <CPagination
                  align="center"
                  addListClass="some-class"
                  activePage={currentPage}
                  pages={totalPage}
                  onActivePageChange={handleCurrentPageChanged}
                />
                <span className="mx-1 d-none d-sm-inline">
                  <strong>totalPage: {totalPage}</strong>
                </span>
              </div>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </>
  )
}

export default memo(Characters)
