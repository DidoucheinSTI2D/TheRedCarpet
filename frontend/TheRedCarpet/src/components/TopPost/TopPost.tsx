import React from 'react';
import "./TopPost.css"

// Pour les call api :
// ici on rajoute a cote de name les trucs que tu veux

const TopPost = ({name}) => {
    return (
        <div className="flex flex-col justify-top items-start gap-[.5rem] h-[4rem]"> 
            <div className='flex justify-center items-center gap-[1rem]'>
                <div className='text-2xl font-medium'>{name}</div>
            </div>
            <hr className='w-full h-[.1rem]'/>
        </div>
    );
};

export default TopPost;