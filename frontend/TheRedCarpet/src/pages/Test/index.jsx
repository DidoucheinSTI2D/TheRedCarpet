import React, { useState } from 'react';
import Post from '../../components/Post/Post';

const Test = () => {
    const fake_bdd = [
        { "name": "John Doe", "likes": 12, "description": "Hello! My name is John Doe." },
        { "name": "Jane Smith", "likes": 25, "description": "Hi! I'm Jane Smith, a software engineer." },
        { "name": "Alice Johnson", "likes": 30, "description": "Greetings! I'm Alice, a graphic designer." },
        { "name": "Bob Brown", "likes": 18, "description": "Hey there! I'm Bob, a digital marketer." },
        { "name": "Charlie Davis", "likes": 22, "description": "Hello! I'm Charlie, a data scientist." },
        { "name": "Diana Prince", "likes": 35, "description": "Hi! I'm Diana, a project manager." },
        { "name": "Ethan Hunt", "likes": 40, "description": "Hello! I'm Ethan, a web developer." },
        { "name": "Fiona Green", "likes": 28, "description": "Hi! I'm Fiona, a content creator." },
        { "name": "George White", "likes": 15, "description": "Hey! I'm George, a photographer." },
        { "name": "Hannah Black", "likes": 50, "description": "Hello! I'm Hannah, a UX/UI designer." }
    ];

    const [memory] = useState(fake_bdd.slice(0, 3)); 
    
    return (
        <div>
            {memory.map((item, index) => (
                <Post data={item} position={index} />
            ))}
        </div>
    );
};

export default Test;