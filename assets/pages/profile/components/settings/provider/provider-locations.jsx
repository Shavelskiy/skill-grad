import React, {useState, useEffect} from 'react'

import axios from 'axios'
import {ALL_LOCATIONS_URL} from '@/utils/profile/endpoints'

import Select from '@/components/react-ui/select'

import css from './scss/provider-locations.scss?module'


const ProviderLocations = ({selectedLocations, setSelectedLocations}) => {
  const [locations, setLocations] = useState([])

  useEffect(() => {
    axios.get(ALL_LOCATIONS_URL)
      .then(({data}) => setLocations(data.locations))
  }, [])

  const getRegionValues = () => {
    if (selectedLocations.country === null) {
      return []
    }

    const countries = locations.filter((city) => city.value === selectedLocations.country)

    return countries.length > 0 ? countries[0].regions : []
  }

  const getCitiesValues = () => {
    if (selectedLocations.region === null) {
      return []
    }

    const regions = getRegionValues().filter((region) => region.value === selectedLocations.region)

    return regions.length > 0 ? regions[0].cities : []
  }

  return (
    <div className={css.locationsContainer}>
      <Select
        placeholder={'Страна'}
        options={locations}
        value={selectedLocations.country}
        setValue={(country) => setSelectedLocations({country: country, region: null, city: null})}
      />
      <Select
        placeholder={'Регион'}
        options={getRegionValues()}
        value={selectedLocations.region}
        setValue={(region) => setSelectedLocations(
          selectedLocations => ({...selectedLocations, region: region, city: null})
        )}
      />
      <Select
        placeholder={'Город'}
        options={getCitiesValues()}
        value={selectedLocations.city}
        setValue={(city) => setSelectedLocations(
          selectedLocations => ({...selectedLocations, city: city})
        )}
      />
    </div>
  )
}

export default ProviderLocations
