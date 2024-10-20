
import React  from 'react'
import Image from 'next/image';

function AddBirdni() {

  return (
    <div>
      <p>HELLOOO</p>

      <div className=''>
      <Image
        src="/MANOK.png"
        width={350}
        height={250}
        alt=""
      />
      <label htmlFor="breed "   className="block mt-4"> BREED: </label>
      <input 
      type="text"
      id="breed"
      placeholder='Talisayon'
      className="border border-gray-300 rounded p-2 mt-2"/>

      <label htmlFor="owner "   className="block mt-4"> Owner: </label>
      <input 
      type="text"
      id="owner"
      placeholder='Kentoy'
      className="border border-gray-300 rounded p-2 mt-2"/>   

      <label htmlFor="handler "   className="block mt-4"> Handler: </label>
      <input 
      type="text"
      id="handler"
      placeholder='BRIAN'
      className="border border-gray-300 rounded p-2 mt-2"/>
      </div>




    </div>
  );
}

export default AddBirdni
