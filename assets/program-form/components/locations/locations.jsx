import React, { useState } from 'react'

import { LOCATIONS } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { selectLocations } from '../../redux/program/actions'

import Block from '../ui/block'
import LocatoinPopup from './locaton-popup'


const Locations = () => {
  const dispatch = useDispatch()

  const [showPopup, setShowPopup] = useState(false)

  return (
    <Block title={LOCATIONS}>
      <LocatoinPopup
        active={showPopup}
        selectedLocations={useSelector(state => state.program.locations)}
        selectLocations={(values) => dispatch(selectLocations(values))}
        close={() => setShowPopup(false)}
      />
      <div onClick={() => setShowPopup(true)}>kek</div>
    </Block>
  )
}

export default Locations
