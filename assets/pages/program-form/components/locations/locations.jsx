import React, { useEffect, useState } from 'react'

import { LOCATIONS } from '@/utils/program-form/titles'

import axios from 'axios'
import { FETCH_ALL_LOCATIONS } from '@/utils/program-form/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { selectLocations } from '../../redux/program/actions'
import { setLocations } from '../../redux/data/actions'
import { focusLocations } from './../../redux/validation/actions'

import Block from '@/components/react-ui/program-form/block'
import LocationPopup from './location-popup'

import css from './scss/locations.scss?module'
import cn from 'classnames'

import deleteImage from '@/img/svg/delete.svg'


const Locations = () => {
  const dispatch = useDispatch()

  const [showPopup, setShowPopup] = useState(false)
  const locations = useSelector(state => state.data.locations)
  const selectedLocations = useSelector(state => state.program.locations)

  useEffect(() => {
    axios.get(FETCH_ALL_LOCATIONS)
      .then(({data}) => dispatch(setLocations(data)))
  }, [])

  const renderLocationList = () => {
    return locations
      .filter(item => item.type === 'region')
      .filter(region => selectedLocations.indexOf(region.id) !== -1 ||
        region.subregions.filter(city => selectedLocations.indexOf(city.id) !== -1) > 0
      )
      .map((region, key) => {
        const cityNames = region.subregions
          .filter(city => selectedLocations.indexOf(city.id) !== -1)
          .map(city => city.name)

        return (
          <div key={key} className={cn(css.item, css.add)}>
            <span className={cn(css.point, css.number)}>{key + 1}</span>
            <input
              className={css.input}
              value={`${region.name}${cityNames.lenght > 0 ? ':' : ''} ${cityNames.join(', ')}`}
              disabled={true}
            />
            <img
              src={deleteImage}
              onClick={() => handleDeleteLocation(region)}
            />
          </div>
        )
      })
  }

  const handleDeleteLocation = (region) => {
    dispatch(selectLocations(
      selectedLocations.filter(
        locationId => locationId !== region.id && region.subregions.filter(city => city.id === locationId).length < 1
      )
    ))
  }

  return (
    <Block title={LOCATIONS} containerClass={css.container} onFocus={focusLocations}>
      {renderLocationList()}
      <div
        className={cn(css.item, css.add)}
        onClick={() => setShowPopup(true)}
      >
        <span className={cn(css.point, css.plus)}></span>
        <span className={css.addButton}>Добавить город/область/район</span>
      </div>
      <div className={cn(css.popupBackground, {[css.active]: showPopup})}></div>
      <LocationPopup
        active={showPopup}
        locations={locations}
        userSelectedLocations={selectedLocations}
        selectLocations={(values) => dispatch(selectLocations(values))}
        close={() => setShowPopup(false)}
      />
    </Block>
  )
}

export default Locations
